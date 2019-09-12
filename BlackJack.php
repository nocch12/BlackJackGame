<?php

require_once('./Player.php');
require_once('./Dealer.php');
require_once('./User.php');
require_once('./Deck.php');

class BlackJack
{
    public $dealer;
    public $user;
    public $deck;

    public function __construct(Dealer $dealer, User $user, Deck $deck)
    {
        $this->dealer = $dealer;
        $this->user = $user;
        $this->deck = $deck;

        switch ($_POST['action']) {
            case 'draw':
                $this->draw();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'start':
                $this->newGame();
                break;
            default:
                header('Location: ./');
                exit;
        }
    }

    private function newGame()
    {
        $this->deck->make();
        $this->deck->shuffle();

        $this->dealer->resetProperty();
        $this->user->resetProperty();

        $this->setSession();
    
        $this->firstDraw();
    }

    private function setSession()
    {
        $_SESSION = [];

        $_SESSION['dealer'] = (array)$this->dealer;
        $_SESSION['user'] = (array)$this->user;
        $_SESSION['deck'] = $this->deck->cards;
    }

    private function firstDraw()
    {
        $this->user->firstDraw();
        $this->dealer->firstDraw();
    }

    public function draw()
    {
        $this->user->draw();
        if ($this->user->isBurst()) {
            $this->decideWinner('user', true);
        }
    }

    public function stop()
    {
        $this->dealer->choiceAction();

        if ($this->dealer->isBurst()) {
            $this->decideWinner('dealer', true);
            return;
        }

        $this->judge();
    }

    public function judge()
    {
        $dealerScore = $this->dealer->score;
        $userScore = $this->user->score;
        
        if ($dealerScore > $userScore) {
            $this->decideWinner('user');
            return;
        } elseif ($dealerScore < $userScore) {
            $this->decideWinner('dealer');
            return;
        }

        $this->isTie();
    }

    public function decideWinner($looser, $burst = false)
    {
        $_SESSION['judge']['isBurst'] = $burst;

        if ($looser === 'user') {
            $_SESSION['judge']['winner'] = 'ディーラー';
            $_SESSION['judge']['looser'] = 'あなた';
            return;
        }

        $_SESSION['judge']['winner'] = 'あなた';
        $_SESSION['judge']['looser'] = 'ディーラー';
    }

    public function isTie()
    {
        $_SESSION['tie'] = '同点です。';
    }
}
