<?php

class Pagination
{
	private $page;
	private $pages;
	public $separator = '<li><a>•••</a></li>';

	public function __construct($pages, $page = 1)
	{
		$this->page = isset($_GET['p']) ? $_GET['p'] : 1;
		$this->pages = $pages;
	}

	public function bootstrapPagination()
	{
		$prev = $this->page-1;
		$next = $this->page+1;

		$disable_prev = '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		$disable_next = '<li class="disabled"><a aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';

		echo '<ul class="pagination">';
		echo ($this->page == 1) ?  $disable_prev : '<li><a href="?p='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';

		$this->render($this->separator);

		echo $this->page == $this->pages ?  $disable_next : '<li><a href="?p='.$next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		echo '</ul>';
	}

	private function render($separator = null)
	{
		// total pages less than or equal to 8
		if ($this->pages <= 8)
		{
			for ($x = 1; $x <= $this->pages; $x++)
			{
				$this->printLink($x);
			}
		}

		// current page less than or equal to 5 and total pages less than or equal to 10
		elseif ($this->page <= 5)
		{
			for ($x = 1; $x <= 6; $x++)
			{
				$this->printLink($x);
			}
			echo $separator;
			for ($x = $this->pages - 1; $x <= $this->pages; $x++)
			{
				$this->printLink($x);
			}
		}

		// current page greater than 5 and total pages greater than 10
		elseif ($this->page <= $this->pages - 5)
		{
			for ($x = 1; $x <= 2; $x++)
			{
				$this->printLink($x);
			}
			echo $separator;
			for ($x = $this->page -2 ; $x <= $this->page -1; $x++)
			{
				$this->printLink($x);
			}
			for ($x = $this->page; $x <= $this->page + 2; $x++)
			{
				$this->printLink($x);
			}
			echo $separator;
			for ($x = $this->pages - 1; $x <= $this->pages; $x++)
			{
				$this->printLink($x);
			}
		}

		// current page greater than or equal to 5 and total pages less than or equal to 10
		else
		{
			for ($x = 1; $x <= 2; $x++)
			{
				$this->printLink($x);
			}
			echo $separator;
			for ($x = $this->pages - 5; $x <= $this->pages; $x++)
			{
				$this->printLink($x);
			}
		}
	}

	private function printLink($x)
	{
		$active = '<li class="active"><a>'.$x.'</a></li>';
		echo $this->page == $x ?  $active : '<li><a href="?p='.$x.'">'.$x.'</a></li>';
	}
}

?>