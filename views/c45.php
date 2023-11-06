<?php
class c45
{
    protected $data;
    protected $target;
    protected $target_values;
    protected $atribut;

    protected $tree;
    protected $atribut_values;

    protected $counter;
    protected $is_debug;

    function __construct($data, $atribut, $target, $is_debug = false)
    {
        $this->data = $data;
        array_pop($atribut);
        foreach ($atribut as $key => $val) {
            $this->atribut[$val] = $val;
        }
        $this->target = $target;
        $this->target_values = $this->possible_values($data, $target);
        $this->is_debug = $is_debug;
        $this->hitung();
    }
    public function display()
    {
        echo "<ul class='c45_tree'><li><a href='javascript:void(0)' class='btn btn-xs btn-danger'>Root</a></li>";
        $this->_display($this->tree);
        echo "</ul>";
    }
    public function _display($tree)
    {
        echo "<ul>";
        foreach ($tree['next'] as $key => $val) {
            echo "<li><a href='javascript:void(0)' class='btn btn-xs btn-primary'> IF <b>$tree[value]</b> Is <b>$key</b> THEN";

            if (!$val['next'])
                echo " <b>$val[value]</b>";
            echo "</a>";

            $this->_display($val);
            echo '</li>';
        }
        echo "</ul>";
    }
    function predict($values)
    {
        $this->counter = 1;
        return $this->_predict($this->tree, $values);
    }

    function _predict($tree, $values)
    {
        $this->counter++;

        if (!$tree['next'])
            return $tree['value'];

        $value = $values[$tree['value']];

        if (isset($tree['next'][$value])) {
            return $this->_predict($tree['next'][$value], $values);
        }
        return 'Undefined';
    }
    function hitung()
    {
        $this->_hitung($this->tree, $this->data, $this->atribut, 'Root');
    }
    function _hitung(&$tree, $data, $atribut, $attr_value = null)
    {
        $this->counter++;
        if ($this->counter > 1000)
            return;

        $target_count = $this->possible_values($data, $this->target);

        if (count($target_count) == 4) { // jika hanya 1 kemungkinan, maka hasil sudah ditemukan
            $this->dd("\n===Hasil Cabang <b>$attr_value</b>:" . key($target_count) . "===");
            $tree['value'] = key($target_count);
            $tree['next'] = array();
            $this->dd("\n");
            return;
        } else { //jika lebih dari 1 lanjur ke bawah
            $this->dd("\n===Perhitungan Cabang <b>$attr_value</b>===");
        }

        $best_gain = -1;
        $best_atribut = 'None';

        if (!$atribut) {
            arsort($target_count);
            $this->dd("\n===Hasil Cabang <b>$attr_value</b>:" . key($target_count) . "===");
            $tree['value'] = key($target_count);
            $tree['next'] = array();
            $this->dd("\n");
            return;
        }
        foreach ($atribut as $attr) {
            $this->dd("\n<span class='text-primary'>$attr</span>:");
            $gain = $this->gain($data, $attr);
            $split_info = $this->split_info($data, $attr);
            $gain_ratio = $split_info == 0 ? $gain : $gain / $split_info;
            $this->dd("\n\t<b class='text-info'>GAIN</b>: " . round($gain, 3) . "");
            $this->dd("\n\t<b class='text-info'>SPLIT INFO</b>: " . round($split_info, 3) . "");
            $this->dd("\n\t<b class='text-info'>GAIN RATIO</b>: " . round($gain_ratio, 3) . "");

            if ($gain_ratio > $best_gain) {
                $best_gain = $gain_ratio;
                $best_atribut = $attr;
            }
        }

        $this->dd("\n<b class='text-success'>Atribut terbaik</b>: $best_atribut (" . round($best_gain, 3) . ")");

        $p = $this->possible_values($data, $best_atribut);
        unset($atribut[$best_atribut]);

        $this->dd("\n");

        foreach ($p as $val => $count) {
            $new_data = $this->filter_data($data, $best_atribut, $val);
            $tree['value'] = $best_atribut;
            $this->_hitung($tree['next'][$val], $new_data, $atribut, "$best_atribut($val)");
        }
    }
    function filter_data($data, $best_attr, $value)
    {
        $arr = array();
        foreach ($data as $val) {
            if ($val[$best_attr] == $value) {
                unset($val[$best_attr]);
                $arr[] = $val;
            }
        }
        return $arr;
    }
    function split_info($data, $attr)
    {
        $values = $this->possible_values($data, $attr);
        $split_info = 0.0;
        $pembagi = array_sum($values);
        foreach ($values as $value => $count) {
            $split_info += $count == 0 ? 0 : $count / $pembagi * log($count / $pembagi, 2);
        }
        return -$split_info;
    }
    function gain($data, $attr)
    {
        $values = $this->possible_values($data, $attr);
        $total = count($data);
        $gain = 0.0;
        foreach ($values as $value => $count) {
            $e = $this->entropy($data, $attr, $value);
            $this->dd("\n\t<span class='text-danger'>$value</span>($count/$total): " . round($e, 3));
            $gain += $e * $count / $total;
        }
        $e = $this->entropy($data);
        return $e - $gain;
    }
    function entropy($data, $attr = null, $value = null)
    {
        $p = $this->calculate_p($data, $attr, $value);
        $entropy = 0.0;
        foreach ($p as $key => $val) {
            $entropy -= $val == 0 ? 0 : $val * log($val, 2);
        }
        return $entropy;
    }
    function calculate_p($data, $attr, $attr_value)
    {
        $p = array();

        foreach ($this->target_values as $key => $val) {
            $p[$key] = 0;
        }

        foreach ($data as $val) {
            if ($attr == null) {
                $p[$val[$this->target]]++;
            } else if ($val[$attr] ==  $attr_value) {
                $p[$val[$this->target]]++;
            }
        }

        $p_total = array_sum($p);
        foreach ($p as $key => &$val) {
            $val /= $p_total;
        }

        return $p;
    }
    private function possible_values($data, $attr)
    {
        $arr = array();
        foreach ($data as $val) {
            $arr[$val[$attr]] = array_key_exists($val[$attr], $arr) ? $arr[$val[$attr]] + 1 : 1;
        }
        return $arr;
    }
    function dd($str)
    {
        if ($this->is_debug)
            echo "$str";
    }
}
