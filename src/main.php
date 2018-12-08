<?php
namespace okaCTO;

class main
{
    /*
     * $strDate - строка с датой в формате YYYY-MM-DD
     */
    public function getData($strDate)
    {
    //    $access_date = '2000-05-27';

    // функция  explode() разбивает  строку другой строкой. В данном случае
    // $access_date разбит на символе "-"

        $date_elements = explode("-", $strDate);

    // здесь
    // $date_elements[0] = 2000
    // $date_elements[1] = 5
    // $date_elements[2] = 27

        return mktime(0,0,0, $date_elements[1], $date_elements[2], $date_elements[0]);
    }

	private function showHead()
	{
		require 'views/head.php';
	}
	
	public function show404()
	{
		$this->showHead();
		require 'views/404.php';
		$this->showFooter();
	}
	
	private function showFooter()
	{
		require 'views/footer.php';
	}
	
	public function showHome()
	{
		$this->showHead();
		require 'views/home.php';
		$this->showFooter();
	}

	/*
	 * Активные тикеты мастера
	 * $tickets - На входе массив с выбранными тикетами
	 */
	public function showTickets($tickets)
	{
		$this->showHead();
		require 'views/tickets.php';
		$this->showFooter();
	}

	/*
	 * $ticket - На входе массив с выбранными тикетами
	 * $closeTicket : 0 - не закрывать тикет
	 *                1 - закрыть тикет
	 */
	public function showChangeTicket($ticket, $closeTicket)
	{
		$this->showHead();
		require 'views/changeTicket.php';
		$this->showFooter();
	}

    /*
     * История закрытых тикетов
     * $tickets - На входе массив с выбранными тикетами
     */
    public function showHistory($tickets)
    {
        $this->showHead();
        require 'views/history.php';
        $this->showFooter();
    }

	public function showApi($text)
	{
		//require 'src/api.php';
	}
		
	
	
}