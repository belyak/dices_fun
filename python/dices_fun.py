import random
import collections


def get_dices(min_edge_value=1, max_edge_value=6, dices_count=5):
    """
    Получение сл. значений пяти кубиков
    :rtype: list of int
    """
    result = []
    for _ in range(dices_count):
        result.append(random.randint(min_edge_value, max_edge_value))
    return result

TWO_OF_KIND = 'two_of_kind'
TWO_PAIRS = 'two_pairs'
THREE_OF_KIND = 'three_of_kind'  # three same
FOUR_OF_KIND = 'four_of_kind'
FULL_HOUSE = 'full house'
SMALL_STRAIGHT = 'small straight'
BIG_STRAIGHT = 'big straight'
YAHTZEE = 'yahtzee'


def max_sequence_length(sequence):

    sorted_sequence = sorted(sequence)

    max_len, seq_len = 1, 1
    curr_ix, next_ix = 0, 1

    while next_ix < len(sorted_sequence):
        curr_elem, next_elem = sorted_sequence[curr_ix], sorted_sequence[next_ix]

        if curr_elem == next_elem:
            next_ix += 1
            continue

        if next_elem - curr_elem == 1:
            seq_len += 1
        else:
            max_len = max(max_len, seq_len)
            seq_len = 1
        curr_ix = next_ix
        next_ix = curr_ix + 1

    return max(max_len, seq_len)


def analyze(dices_combination):
    """
    Выводит комбинацию если она имеется в наборе костей
    :type dices_combination: list of int
    """

    c = collections.Counter()

    for d in dices_combination:
        c[d] += 1

    counter_values = sorted(c.values())

    max_sequence_len = max_sequence_length(dices_combination)

    if max_sequence_len == 5:
        return BIG_STRAIGHT
    elif max_sequence_len == 4:
        return SMALL_STRAIGHT

    if 5 in counter_values:
        return YAHTZEE
    elif 4 in counter_values:
        return FOUR_OF_KIND
    elif 3 in counter_values:
        if 2 in counter_values:
            return FULL_HOUSE
        else:
            return THREE_OF_KIND
    elif 2 in counter_values:
        if [c for c in counter_values if c == 2] == [2, 2]:
            return TWO_PAIRS
        else:
            return TWO_OF_KIND


def run_until_combination(combination, max_cycles=None):
    c = 0
    while True:
        dices = get_dices()
        if analyze(dices) == combination:
            print(dices, combination)
            break
        if max_cycles is not None and c == max_cycles:
            print('Unable to find combination %s after %d cycles!' % (combination, max_cycles))
            break
        c += 1



if __name__ == '__main__':
    run_until_combination(FOUR_OF_KIND, max_cycles=10)