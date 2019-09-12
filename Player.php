<?php

abstract class Player
{
    protected $hand;
    protected $score;

    public function resetProperty()
    {
        $this->hand = null;
        $this->score = null;
    }

    public function setSession()
    {
    }

    public function draw()
    {
        $card = array_shift($_SESSION['deck']);
        
        $cardNum = $this->convertCourtCard($card);
        
        $this->setDrawMessage($card, $cardNum);
        
        $this->hand[] = $card;
        
        $this->setScore($cardNum);
    }

    public function setDrawMessage($card, $cardNum)
    {
    }

    public function convertCourtCard($card)
    {
        switch ($card['rank']) {
            case 11:
                return 'J';
                break;
            case 12:
                return 'Q';
                break;
            case 13:
                return 'K';
                break;
            case 1:
                return 'A';
                break;
        }

        return $card['rank'];
    }

    public function setScore($cardNum)
    {
        $card_point = $cardNum;

        if ($cardNum === 'J' ||
           $cardNum === 'Q' ||
           $cardNum === 'K') {
            $card_point = 10;
        } elseif ($cardNum === 'A') {
            $card_point = $this->ace();
        }

        $this->score += $card_point;

        $this->setSession();
    }

    public function ace()
    {
        if ($this->score < 11) {
            return 11;
        }
        return 1;
    }
    
    public function isBurst()
    {
        if ($this->score > 21) {
            return true;
        }
        return false;
    }

    public function firstDraw()
    {
        $this->draw();
        $this->draw();
    }
}
