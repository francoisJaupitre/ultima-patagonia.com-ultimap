<?php
/*$a = array("U","L","T","I","M","A");
foreach($a as $i => $x){
  $r[$i] = $x;
  $b = $a;
  unset($b[$i]);
  foreach($b as $j => $x){
    $s[$i][$j] = $x;
    $c = $b;
    unset($c[$j]);
    foreach($c as $k => $x){
      $t[$i][$j][$k] = $x;
      $d = $c;
      unset($d[$k]);
      foreach($d as $l => $x){
        $u[$i][$j][$k][$l] = $x;
        $e = $d;
        unset($e[$l]);
        foreach($e as $m => $x){
          $v[$i][$j][$k][$l][$m] = $x;
          $f = $e;
          unset($f[$m]);
          foreach($f as $n => $x) {$w[$i][$j][$k][$l][$m][$n] = $x;}
        }
      }
    }
  }
}
foreach($r as $i => $x1){
  foreach($s[$i] as $j => $x2){
    foreach($t[$i][$j] as $k => $x3){
      foreach($u[$i][$j][$k] as $l => $x4){
        foreach($v[$i][$j][$k][$l] as $m => $x5){
          foreach($w[$i][$j][$k][$l][$m] as $x6){
            echo $x1.$x2.$x3.$x4.$x5.$x6.'<BR/>';

          }
        }
      }
    }
  }
}*/
$a1 = array("U","L","T","I","M","A"," ","P","A","T","A","G","O","N","I","A");
foreach($a1 as $i1 => $x){
  if(!isset($r1) or !in_array($x,$r1)){
    $r1[$i1] = $x;
    $a2 = $a1;
    unset($a2[$i1]);
    foreach($a2 as $i2 => $x){
      if(!isset($r2[$i1]) or !in_array($x,$r2[$i1])){
        $r2[$i1][$i2] = $x;
        $a3 = $a2;
        unset($a3[$i2]);
        foreach($a3 as $i3 => $x){
          if(!isset($r3[$i1][$i2]) or !in_array($x,$r3[$i1][$i2])){
            $r3[$i1][$i2][$i3] = $x;
            $a4 = $a3;
            unset($a4[$i3]);
            foreach($a4 as $i4 => $x){
              if(!isset($r4[$i1][$i2][$i3]) or !in_array($x,$r4[$i1][$i2][$i3])){
                $r4[$i1][$i2][$i3][$i4] = $x;
                $a5 = $a4;
                unset($a5[$i4]);
                foreach($a5 as $i5 => $x){
                  if(!isset($r5[$i1][$i2][$i3][$i4]) or !in_array($x,$r5[$i1][$i2][$i3][$i4])){
                    $r5[$i1][$i2][$i3][$i4][$i5] = $x;
                    $a6 = $a5;
                    unset($a6[$i5]);
                    foreach($a6 as $i6 => $x){
                      if(!isset($r6[$i1][$i2][$i3][$i4][$i5]) or !in_array($x,$r6[$i1][$i2][$i3][$i4][$i5])){
                        $r6[$i1][$i2][$i3][$i4][$i5][$i6] = $x;
                        $a7 = $a6;
                        unset($a7[$i6]);
                        foreach($a7 as $i7 => $x){
                          if(!isset($r7[$i1][$i2][$i3][$i4][$i5][$i6]) or !in_array($x,$r7[$i1][$i2][$i3][$i4][$i5][$i6])){
                            $r7[$i1][$i2][$i3][$i4][$i5][$i6][$i7] = $x;
                            $a8 = $a7;
                            unset($a8[$i7]);
                            foreach($a8 as $i8 => $x){
                              if(!isset($r8[$i1][$i2][$i3][$i4][$i5][$i6][$i7]) or !in_array($x,$r8[$i1][$i2][$i3][$i4][$i5][$i6][$i7])){
                                $r8[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8] = $x;
                                $a9 = $a8;
                                unset($a9[$i8]);
                                foreach($a9 as $i9 => $x){
                                  if(!isset($r9[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8]) or !in_array($x,$r9[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8])){
                                    $r9[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9] = $x;
                                    /*$a10 = $a9;
                                    unset($a10[$i9]);
                                    foreach($a10 as $i10 => $x){
                                      if(!isset($r10[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9]) or !in_array($x,$r10[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9])){
                                        $r10[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10] = $x;
                                        $a11 = $a10;
                                        unset($a11[$i10]);
                                        foreach($a11 as $i11 => $x){
                                          if(!isset($r11[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10]) or !in_array($x,$r11[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10])){
                                            $r11[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11] = $x;
                                            $a12 = $a11;
                                            unset($a12[$i11]);
                                            foreach($a12 as $i12 => $x){
                                              if(!isset($r12[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11]) or !in_array($x,$r12[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11])){
                                                $r12[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12] = $x; echo $x;
                                                /*$a13 = $a12;
                                                unset($a13[$i12]);
                                                foreach($a13 as $i13 => $x){
                                                  $r13[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13] = $x;
                                                  $a14 = $a13;
                                                  unset($a14[$i13]);
                                                  foreach($a14 as $i14 => $x){
                                                    $r14[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13][$i14] = $x;
                                                    $a15 = $a14;
                                                    unset($a15[$i14]);
                                                    foreach($a15 as $i15 => $x){
                                                      $r15[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13][$i14][$i15] = $x;
                                                      $a16 = $a15;
                                                      unset($a16[$i15]);
                                                      foreach($a16 as $i16 => $x){
                                                        $r16[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13][$i14][$i15][$i16] = $x;
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }*/
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
}
var_dump($r1);
foreach($r1 as $i1 => $x1){
  foreach($r2[$i1] as $i2 => $x2){
    foreach($r3[$i1][$i2] as $i3 => $x3){
      foreach($r4[$i1][$i2][$i3] as $i4 => $x4){
        foreach($r5[$i1][$i2][$i3][$i4] as $i5 => $x5){
          foreach($r6[$i1][$i2][$i3][$i4][$i5] as $i6 => $x6){
            foreach($r7[$i1][$i2][$i3][$i4][$i5][$i6] as $i7 => $x7){
              foreach($r8[$i1][$i1][$i3][$i4][$i5][$i6][$i7] as $i8 => $x8){
                foreach($r9[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8] as $i9 => $x9){
                  //foreach($r10[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9] as $i10 => $x10){
                  //  foreach($r11[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10] as $i11 => $x11){
                      //foreach($r12[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11] as $i12 => $x12){
                      //  foreach($r13[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12] as $i13 => $x13){
                          //foreach($r14[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13] as $i14 => $x14){
                            //foreach($r15[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13][$i14] as $i15 => $x15){
                              //foreach($r16[$i1][$i2][$i3][$i4][$i5][$i6][$i7][$i8][$i9][$i10][$i11][$i12][$i13][$i14][$i15] as $x16){
                                $r0 = $x1.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10.$x11;//.$x12;//.$x13.$x14.$x15.$x16;
                                if (
                                  strpos($r0, 'AA') === false
                                  and strpos($r0, 'II') === false
                                  and strpos($r0, 'GT') === false
                                  and strpos($r0, 'GP') === false
                                  and strpos($r0, 'GNT') === false
                                  and strpos($r0, 'GNP') === false
                                  and strpos($r0, 'PG') === false
                                  and strpos($r0, 'PNT') === false
                                  and strpos($r0, 'PNG') === false
                                  and strpos($r0, 'PTN') === false
                                  and strpos($r0, 'PTG') === false
                                  and strpos($r0, 'TG') === false
                                  and strpos($r0, 'TN') === false
                                  and strpos($r0, 'TP') === false
                                ) {$s0[] = $r0;}
                              //}
                            //}
                          //}
                        //}
                    //}
                  //  }
                //  }
                }
              }
            }
          }
        }
      }
    }
  }
}

$s1 = array_unique($s0);
foreach($s1 as $x){
  echo $x.'<BR/>';
}
?>
