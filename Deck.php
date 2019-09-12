<?php

class Deck
{
    public $cards;

    public function make()
    {
        $suits = ['スペード', 'クラブ', 'ダイヤ', 'ハート'];

        $ranks = range(1, 13);

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = [
                    'suit' => $suit,
                    'rank' => $rank
                ];
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }
}
