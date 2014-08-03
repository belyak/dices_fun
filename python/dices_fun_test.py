from unittest import TestCase
import dices_fun
from dices_fun import analyze, max_sequence_length


class TestMaxIncrementalSequence(TestCase):
    def test_max_inc_sequence(self):

        data = (
            ([5, 3, 4, 1, 2, 3], 5),
            ([7, 7, 7, 6, 4, 3, 1], 2),
            ([1, 3, 5, 7], 1),
            ([9, 8, 7, 7, 7, 6, 5, 4], 6),
            ([1, 2, 3], 3)
        )

        for sequence, expected_len, in data:
            self.assertEquals(expected_len, max_sequence_length(sequence), sequence)


class TestAnalyze(TestCase):
    def test_analyze(self):
        test_data = (
            ([1, 2, 3, 5, 3], dices_fun.TWO_OF_KIND, "Двойка не работает"),
            ([1, 2, 1, 3, 1], dices_fun.THREE_OF_KIND, "Тройка не работает"),
            ([2, 4, 4, 4, 4], dices_fun.FOUR_OF_KIND, "Четверка облом!"),
            ([2, 1, 3, 1, 2], dices_fun.TWO_PAIRS, "Две пары (("),
            ([3, 3, 3, 3, 3], dices_fun.YAHTZEE, "5 не работает"),
            ([1, 2, 3, 4, 5], dices_fun.BIG_STRAIGHT, "Биг стрит не работает!"),
            ([2, 3, 4, 5, 6], dices_fun.BIG_STRAIGHT, "Биг стрит не работает!"),

            ([1, 3, 2, 4, 6], dices_fun.SMALL_STRAIGHT, "смол стрит не работает!"),
            ([2, 3, 4, 5, 3], dices_fun.SMALL_STRAIGHT, "смол стрит не работает!"),
            ([1, 3, 4, 5, 6], dices_fun.SMALL_STRAIGHT, "смол стрит не работает!"),
        )

        for combination, expected_result, message, in test_data:
            self.assertEquals(analyze(combination), expected_result, '%s %s ' % (message, combination))
