<?php
// $Id: swish-e.class.php,v 1.2 2005/03/14 20:05:43 jsaucier Exp $
//  ------------------------------------------------------------------------ //
//                           Document Manager                                //
//            Copyright (c) 2004 Informatique Strategique IS                 //
//                  <http://www.infostrategique.com/>                        //
//                      Original Author : Olivier Meunier                    //
//               <http://www.neokraft.net/src/class.swish.php>               //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


class swish
{
	
	var $str_engine = "/usr/bin/swish-e";
	var $str_index_file;
	
	var $str_separator = "@@@@@";
	
	var $words;
	var $get_params;
	var $sort_params;
	var $first_result;
	var $last_result;
	
	var $number_results;
	var $arry_res;
    
	// Modifiable array name
	var $title_line = "TITLE";
	var $url_line = "URL";
	var $score_line = "SCORE";
	var $err = FALSE;
    
    
	/**
	* Constructor
	*
	* @str_index_file	string		Path to index file
	* @str_engine		string		Path to swish-e
	*
	* return			void	
	*/
	function swish($str_index_file, $str_engine = "") {
		$this->str_index_file = $str_index_file;
		
		if ($str_engine != "") {
			$this->str_engine = $str_engine;
        }
	}
    
    
	/**
	* Method: set_params
	*
	* @words			string		Search string
	* @get_params		array		Param array
	* @sort_params		string		Order param
	* @first_result	integer		First result index
	* @last_resulte	integer		Number of max result
	*
	* return			void
	*/
	function set_params($words, $get_params = array(), $sort_params = "", $first_result = "", $last_result = "") {
		$this->words = $words;
		$this->get_params = $get_params;
		$this->sort_params = $sort_params;
		$this->first_result = $first_result;
		$this->last_result = $last_result;
	}
	
	
	/**
	* Method: exec_swish
	*
	* return			void
	*/
	function exec_swish() {
    
		// Escape evil command and prepare shell command
		$this->words = escapeshellcmd($this->words);
		$this->words = str_replace('\*', '*', $this->words);
		
		$cmd =	$this->str_engine . " " . ' -f ' . $this->str_index_file . ' -w "' . $this->words . '"' . ' -d ' . $this->str_separator;
		
        
        // Add paramter if they exist (-p)
		if(count($this->get_params) > 0)
		{
			$ligne_params = implode(" ", $this->get_params);
			$cmd .= " -p " . $ligne_params;
		}
		
        // Add order param if exist
		if ($this->sort_params != "") {
			$cmd .= " -s " . $this->sort_params; 
		}
		
        
		// Add first hit position if exist
		if ($this->first_result != "") {
			$cmd .= " -b ".$this->first_result;
		}
		
		// Add number of line max if exist
		if ($this->last_result != "") {
			$cmd .= " -m " . $this->last_result;
		}
		
		// Start the shell command
		$this->cmd = $cmd;
		exec($cmd, $this->arry_swish);
        
		// The result is in the array
	}
	
	
    
	/**
	* Make something with the result
	*
	* return			void
	*/	
	function make_result() {
    
		$i=0;
		
		// We check all the array line
		foreach ($this->arry_swish as $value)
		{
			// If we find an error, we stop everything
			if (ereg("^err", $value)) {
				$this->err = TRUE;
				break 1;
			}			
            
			// Get the result number
			if (ereg("^# Number of hits: ([0-9]*)", $value, $Tnb)) {
				$this->number_results = $Tnb[1];
			}
			
			
            // Result line
			if (!ereg("^[.#]", $value)) {
            
				// We put the result in an array
				$arry_tmp = explode($this->str_separator, $value);
				
				// Get score, url and title
				$arry_int[$this->score_line] = $arry_tmp[0];
				$arry_int[$this->url_line] = $arry_tmp[1];
				$arry_int[$this->title_line] = $arry_tmp[2];
				$arry_int['DOCSIZE'] = $arry_tmp[3];
				
				
                // Param traitement
				reset($this->get_params);
                
				for ($j=4; $j<count($arry_tmp); $j++) {
					$arry_int[key($this->get_params)] = $arry_tmp[$j];
					next($this->get_params);
				}
                
				$this->arry_res[$i] = $arry_int;
                
				$i++;
			}
		}
	}
	
	
	/**
	* Execution complete
	*
	* return			array		Result array
	*/
	function get_result() {
		$this->exec_swish();
		$this->make_result();
		return $this->arry_res;
	}

}

?>
