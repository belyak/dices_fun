<?php

/**
 * Ищет длину максимальной последовательности чисел в массиве, которые можно выстроить по возрастанию с шагом 1
 * @param array $sequence массив, в котором производится поиск
 * @return mixed
 */
function maxSequenceLength($sequence) {

    $sorted_sequence = $sequence;
    sort($sorted_sequence);

    $max_len = 1;
    $seq_len = 1;
    $curr_ix = 0;
    $next_ix = 1;

    while ($next_ix < count($sorted_sequence)) {
        $curr_elem = $sorted_sequence[$curr_ix];
        $next_elem = $sorted_sequence[$next_ix];

        if ($curr_elem == $next_elem) {
            $next_ix++;
            continue;
        }

        if ($next_elem - $curr_elem == 1) {
            $seq_len++;
        } else {
            $max_len = max($seq_len, $max_len);
            $seq_len = 1;
        }

        $curr_ix = $next_ix;
        $next_ix++;
    }

    return max($seq_len, $max_len);
}

/**
 * возвращает массив со случайными значениями выпавших костей.
 *
 * @param int $min_edge_value минимальное значение кости
 * @param int $max_edge_value максимальное значение кости
 * @param int $dices_count количество костей
 * @return array
 */
function getDIcesCombination($min_edge_value=1, $max_edge_value=6, $dices_count=5) {
    $result = array();
    for ($i = 0; $i < $dices_count; $i++) {
        $result[] = rand($min_edge_value, $max_edge_value);
    }
    return $result;
}


Interface Combinations {
    const TWO_OF_KIND = 'two_of_kind';
    const TWO_PAIRS = 'two_pairs';
    const THREE_OF_KIND = 'three_of_kind';
    const FOUR_OF_KIND = 'four_of_kind';
    const FULL_HOUSE = 'full house';
    const SMALL_STRAIGHT = 'small straight';
    const BIG_STRAIGHT = 'big straight';
    const YAHTZEE = 'yahtzee';
    const NO_COMBINATION = 'no combination!';
}

/**
 * @param array $dices_combination комбинация костей для анализа
 * @return string
 */
function analyze($dices_combination) {
    $counter = array();

    foreach ($dices_combination as $dice_value) {
        if (!isset($counter[$dice_value])) {
            $counter[$dice_value] = 1;
        } else {
            $counter[$dice_value]++;
        }
    }

    $counterValues = array_values($counter);

    $maxSequenceLen = maxSequenceLength($dices_combination);

    if ($maxSequenceLen == 5) {
        return Combinations::BIG_STRAIGHT;
    } else if ($maxSequenceLen == 4) {
        return Combinations::SMALL_STRAIGHT;
    }

    if (in_array(5, $counterValues)) {
        return Combinations::YAHTZEE;
    } else if (in_array(4, $counterValues)) {
        return Combinations::FOUR_OF_KIND;
    } else if (in_array(3, $counterValues)) {
        if (in_array(2, $counterValues)) {
            return Combinations::FULL_HOUSE;
        } else {
            return Combinations::THREE_OF_KIND;
        }
    } else if (in_array(2, $counterValues)) {
        $pairsCount = 0;
        foreach($counterValues as $cv) {
            if ($cv == 2) {
                $pairsCount++;
            }
        }
        if ($pairsCount == 2) {
            return Combinations::TWO_PAIRS;
        } else {
            return Combinations::TWO_OF_KIND;
        }
    } else {
        return Combinations::NO_COMBINATION;
    }
}


function runUntilCombination($combination, $max_cycles=null) {
    for ($c = 0; $max_cycles === null or $c < $max_cycles; $c++) {
        $dices = getDIcesCombination();
        $curr_combination = analyze($dices);
        if ($curr_combination == $combination) {
            print("Combination $combination: [".implode(', ', $dices)."]\n");
            return true;
        }
    }
    print("Combination $combination has not been met for $max_cycles cycles!\n");
    return false;
}

runUntilCombination(Combinations::SMALL_STRAIGHT, 10);