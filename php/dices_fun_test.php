<?php

require_once('dices_fun.php');

class DicesFunTest extends PHPUnit_Framework_TestCase {
    public function testSequenceLength() {
        $data = array(
            array(array(5, 3, 4, 1, 2, 3), 5),
            array(array(7, 7, 7, 6, 4, 3, 1), 2),
            array(array(1, 3, 5, 7), 1),
            array(array(9, 8, 7, 7, 7, 6, 5, 4), 6),
            array(array(1, 2, 3), 3)
        );

        foreach ($data as $test_data_and_result) {
            $test_data = $test_data_and_result[0];
            $expected_result = $test_data_and_result[1];

            $result = maxSequenceLength($test_data);
            $this->assertEquals($expected_result, $result);
        }
    }

    public function testAnalyze() {
        $test_data = array(
            array("dices"=>array(1, 2, 3, 5, 3), "expected_result"=>Combinations::TWO_OF_KIND),
            array("dices"=>array(1, 2, 1, 3, 1), "expected_result"=> Combinations::THREE_OF_KIND),
            array("dices"=>array(2, 4, 4, 4, 4), "expected_result"=> Combinations::FOUR_OF_KIND),
            array("dices"=>array(2, 1, 3, 1, 2), "expected_result"=> Combinations::TWO_PAIRS),
            array("dices"=>array(3, 3, 3, 3, 3), "expected_result"=> Combinations::YAHTZEE),
            array("dices"=>array(1, 2, 3, 4, 5), "expected_result"=> Combinations::BIG_STRAIGHT),
            array("dices"=>array(2, 3, 4, 5, 6), "expected_result"=> Combinations::BIG_STRAIGHT),

            array("dices"=>array(1, 3, 2, 4, 6), "expected_result"=> Combinations::SMALL_STRAIGHT),
            array("dices"=>array(2, 3, 4, 5, 3), "expected_result"=> Combinations::SMALL_STRAIGHT),
            array("dices"=>array(1, 3, 4, 5, 6), "expected_result"=> Combinations::SMALL_STRAIGHT)
        );

        foreach ($test_data as $td) {
            $dices = $td['dices'];
            $expectedResult = $td['expected_result'];
            $result = analyze($dices);
            $this->assertEquals($expectedResult, $result);
        }
    }
}
 