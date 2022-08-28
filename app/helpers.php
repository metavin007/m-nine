<?php

function bahtEng($thb) {
    list($thb, $ths) = explode('.', $thb);
    $ths = substr($ths . '00', 0, 2);
    $thb = engFormat(intval($thb)) . ' Baht';
    if (intval($ths) > 0) {
        $thb .= ' and ' . engFormat(intval($ths)) . ' Satang';
    }
    return $thb;
}

// ตัวเลขเป็นตัวหนังสือ (eng)
function engFormat($number) {
    $suffix = '';
    $max_size = pow(10, 18);
    if (!$number)
        return "Zero";
    if (is_int($number) && $number < abs($max_size)) {
        switch ($number) {
            case $number < 0:
                $prefix = "negative";
                $suffix = engFormat(-1 * $number);
                $string = $prefix . " " . $suffix;
                break;
            case 1:
                $string = "One";
                break;
            case 2:
                $string = "Two";
                break;
            case 3:
                $string = "Three";
                break;
            case 4:
                $string = "Four";
                break;
            case 5:
                $string = "Five";
                break;
            case 6:
                $string = "Six";
                break;
            case 7:
                $string = "Seven";
                break;
            case 8:
                $string = "Eight";
                break;
            case 9:
                $string = "Nine";
                break;
            case 10:
                $string = "Ten";
                break;
            case 11:
                $string = "Eleven";
                break;
            case 12:
                $string = "Twelve";
                break;
            case 13:
                $string = "Thirteen";
                break;
            case 15:
                $string = "Fifteen";
                break;
            case $number < 20:
                $string = engFormat($number % 10);
                if ($number == 18) {
                    $suffix = "een";
                } else {
                    $suffix = "Teen";
                }
                $string .= $suffix;
                break;
            case 20:
                $string = "Twenty";
                break;
            case 30:
                $string = "Thirty";
                break;
            case 40:
                $string = "Forty";
                break;
            case 50:
                $string = "Fifty";
                break;
            case 60:
                $string = "Sixty";
                break;
            case 70:
                $string = "Seventy";
                break;
            case 80:
                $string = "Eighty";
                break;
            case 90:
                $string = "Ninety";
                break;
            case $number < 100:
                $prefix = engFormat($number - $number % 10);
                $suffix = engFormat($number % 10);
                $string = $prefix . "-" . $suffix;
                break;
            case $number < pow(10, 3):
                $prefix = engFormat(intval(floor($number / pow(10, 2)))) . " Hundred";
                if ($number % pow(10, 2))
                    $suffix = " and " . engFormat($number % pow(10, 2));
                $string = $prefix . $suffix;
                break;
            case $number < pow(10, 6):
                $prefix = engFormat(intval(floor($number / pow(10, 3)))) . " Thousand";
                if ($number % pow(10, 3))
                    $suffix = engFormat($number % pow(10, 3));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10, 9):
                $prefix = engFormat(intval(floor($number / pow(10, 6)))) . " Million";
                if ($number % pow(10, 6))
                    $suffix = engFormat($number % pow(10, 6));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10, 12):
                $prefix = engFormat(intval(floor($number / pow(10, 9)))) . " Billion";
                if ($number % pow(10, 9))
                    $suffix = engFormat($number % pow(10, 9));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10, 15):
                $prefix = engFormat(intval(floor($number / pow(10, 12)))) . " Trillion";
                if ($number % pow(10, 12))
                    $suffix = engFormat($number % pow(10, 12));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10, 18):
                $prefix = engFormat(intval(floor($number / pow(10, 15)))) . " Quadrillion";
                if ($number % pow(10, 15))
                    $suffix = engFormat($number % pow(10, 15));
                $string = $prefix . " " . $suffix;
                break;
        }
    }
    return $string;
}

function convert_to_thai($number) {
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) AND $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) AND $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) AND $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }

    $convert .= 'บาท';
    if ($number[1] == '0' OR $number[1] == '00' OR
            $number[1] == '') {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) AND $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) AND
                        $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) AND
                        $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}

function getMBStrSplit($string, $split_length = 1) {
    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');
    $split_length = ($split_length <= 0) ? 1 : $split_length;
    $mb_strlen = mb_strlen($string, 'utf-8');
    $array = array();
    $i = 0;

    while ($i < $mb_strlen) {
        $array[] = mb_substr($string, $i, $split_length);
        $i = $i + $split_length;
    }

    return $array;
}

function str_len_th($string) {
    $array = getMBStrSplit($string);
    $count = 0;
    foreach ($array as $value) {
        $ascii = ord(iconv("UTF-8", "TIS-620//TRANSLIT", $value));

        if (!( $ascii == 209 || ($ascii >= 212 && $ascii <= 218 ) || ($ascii >= 231 && $ascii <= 238 ))) {
            $count += 1;
        }
    }
    return $count;
}

function sub_str_th($string, $start, $length) {
    $length = ($length + $start) - 1;
    $array = getMBStrSplit($string);
    $count = 0;
    $return = "";

    for ($i = $start; $i < count($array); $i++) {
        $ascii = ord(iconv("UTF-8", "TIS-620//TRANSLIT", $array[$i]));

        if ($ascii == 209 || ($ascii >= 212 && $ascii <= 218 ) || ($ascii >= 231 && $ascii <= 238 )) {
            //$start++;
            $length++;
        }

        if ($i >= $start) {
            $return .= $array[$i];
        }

        if ($i >= $length)
            break;
    }

    return $return;
}

function find_value_percent($value, $percent) {
    $total = (($value * $percent) / 100);
    return $total;
}

function format_address_for_pdf($house_no, $address_detail, $moo, $soi, $road, $tambon, $amphur, $province, $zipcode) {
    $text = '';
    if ($house_no) {
        $text .= $house_no;
    }
    if ($address_detail) {
        $text .= $address_detail;
    }
    if ($moo) {
        $text .= ' หมู่' . $moo;
    }
    if ($soi) {
        $text .= ' ซอย' . $soi;
    }
    if ($road) {
        $text .= ' ถนน' . $road;
    }
    if ($tambon && $province == 'กรุงเทพมหานคร') {
        $text .= ' แขวง' . $tambon;
    } else if ($tambon) {
        $text .= ' ตำบล' . $tambon;
    }
    if ($amphur && $province == 'กรุงเทพมหานคร') {
        $text .= ' เขต' . $amphur;
    } else if ($amphur) {
        $text .= ' อำเภอ' . $amphur;
    }
    if ($province && $province == 'กรุงเทพมหานคร') {
        $text .= ' ' . $province;
    } else if ($province) {
        $text .= ' จังหวัด' . $province;
    }
    if ($zipcode) {
        $text .= ' ' . $zipcode;
    }
    return $text;
}

//function utf8_strlen($s) {
//    $c = strlen($s);
//    $l = 0;
//    for ($i = 0; $i < $c; ++$i)
//        if ((ord($s[$i]) & 0xC0) != 0x80)
//            ++$l;
//    return $l;
//}
//
//            <td class="table" style="text-align: left;">
//                <?php
//                $len_code = utf8_strlen($sub_table->spare_part_code);
//                if ($len_code > 15) {
//                    echo mb_strimwidth($sub_table->spare_part_code, 0, 15, "...");
//                } else {
//                    echo $sub_table->spare_part_code;
//                }
//          
//                $len_name = utf8_strlen($sub_table->spare_part_name);
//                if ($len_name > 35) {
//                    echo mb_strimwidth($sub_table->spare_part_name, 0, 35, "...");
//                } else {
//                    echo $sub_table->spare_part_name;
//                }
//              


function date_format_system_not_time($date) {
    return date('d-m-Y', strtotime($date));
}

function date_format_system_not_second($date) {
    return date('d-m-Y H:i', strtotime($date));
}

function date_format_system($date) {
    return date('d-m-Y H:i:s', strtotime($date));
}

function date_format_database($date) {
    return date('Y-m-d H:i:s', strtotime($date));
}

function convert_number_to_strin_thai($number) {
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) AND $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) AND $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) AND $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }

    $convert .= 'บาท';
    if ($number[1] == '0' OR $number[1] == '00' OR
            $number[1] == '') {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) AND $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) AND
                        $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) AND
                        $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}

function convert_month_number_to_month_thai($number) {
    $months = array(1 => "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน"
        , "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน"
        , "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    return $months[$number];
}
