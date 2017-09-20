<?php 

 /******************************************************************

   Projectname:   pagination class
   Version:       1.00
   Author:        MAJID RAMZANI 
   
   site : http://majidramzani.com

   Last modified: 16. MARCH 2012

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   email  : majideramzani@gmail.com 
  ******************************************************************/

	error_reporting(E_ALL);

class pagination{

public 		$Start			;		// start of selection : use in mysql query to get content

public 		$End			;		// end of selection : use in mysql query to get content

private 	$Number			;		//number of totall content

public	 	$Pages			;		// number of page after set category process

private 	$N_p_p			;		//number of content per page

private 	$Page_number	;		//number of current page

private		$Buttons		;		//number of max buttons


 
 function __construct($number,$n_p_p=10,$page_number=1,$buttons=5)
	{
	
	//page start from 1 
	
	$page_number	=	($page_number<1)	?	1	:	$page_number	;

	$this->		Number		=	$number			;

	$this->		N_p_p		=	$n_p_p			;

	$this->		Pages		=	ceil	(	$this->	Number	/	$this->	N_p_p	)	;

	$this->		Buttons		=	$buttons		;

	$page_number			=	($page_number>$this->Pages)	?	$this->Pages	:	$page_number	;
	
	$this->		Page_number	=	$page_number	;
	
	$this->		Ret()	;
	}

 public function Show_Pagination($link,$get='page',$div_class_name='pagination')
	{

	//if pages == 1 , no need to print pagination

	if($this->Pages==1)return;

	//$link is the addres of current page
	
	//$get is name of get method

	//echo pagination's div
	
	echo'<div class="'.$div_class_name.'">';
	echo '<ul>';
	//echo pre button
	
	if($this->Page_number>1)echo '<li><a  href="'.$link.'&'.$get.'='.($this->Page_number -1 ).'">Ant</a></li>';
	
	else echo '<li><a>Ant</a></li>';
	
	//print button
	
	$this->Buttons=(int)$this->Buttons;
	
	$start_counter	=	$this->Page_number-floor($this->Buttons/2);			//for normal mode
	
	$end_conter		=	$this->Page_number+floor($this->Buttons/2);			//for normal mode
	
	//try to buttons exactly equal to $Buttons
	
	if($start_counter<1) $end_conter=$end_conter+abs($start_counter);		
	
	if($end_conter>$this->Pages) $start_counter=$start_counter-($end_conter-$this->Pages);
	
	if(($this->Page_number-floor($this->Buttons/2))<1)$end_conter ++;
	
	
	
	for ($i=$start_counter;$i<=$end_conter;$i++)
			{
	
			if($i>$this->Pages || $i<1)continue;		//no print less than 1 value or grater than totall page
	
			if($i==$this->Page_number)echo '<li class="current"><a>'.$i.'</a></li>'; 		// change current page' class
	
			else echo '<li><a  href="'.$link.'&'.$get.'='.$i.'">'.$i.'</a></li>';  	// normal pages
	
			}
			
	
	//echo next button
	
	if($this->Page_number<$this->Pages)echo '<li><a  href="'.$link.'&'.$get.'='. ($this->Page_number +1 ) .'">Sig</a></li>';
	
	else echo '<li><a>Sig</a></li>';		
	
	//close div tag
	echo '</ul>';
	echo'</div>';
	
	}


	//give the page number and return start and end of selection 

 private function  Ret()
	{

	$this->Start=(($this->Page_number-1)*$this->N_p_p);

	$this->End=  $this->N_p_p ;

	}



}