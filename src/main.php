<?php
namespace okaCTO;

class main
{
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
	
	public function showTickets($tickets)
	{
		$this->showHead();
		require 'views/tickets.php';
		$this->showFooter();
	}
	
	public function showChangeTicket($ticket, $closeTicket)
	{
		$this->showHead();
		require 'views/changeTicket.php';
		$this->showFooter();
	}
	
	public function showApi($text)
	{
		//require 'src/api.php';
	}
		
	
	
}