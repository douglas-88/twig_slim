<?php


namespace App\traits;


trait Links
{
   protected $maxLinks = 4;

   private function previous(){

       if($this->page > 1){

           $previous = $this->page - 1;

           $links = "<li class=\"page-item\"><a class=\"page-link\" href=\"?page=1\">[1]</a></li>";
           $links .= "<li class=\"page-item\">
                      <a class=\"page-link\" href=\"?page={$previous}\" aria-label=\"Previous\">
                        <span aria-hidden=\"true\">&laquo;</span>
                        <span class=\"sr-only\">Previous</span>
                      </a>
                    </li>";

           return $links;
       }

   }

   private function next(){

       if($this->page < $this->pages){

           $next = $this->page + 1;

           $links = "<li class=\"page-item\">
                      <a class=\"page-link\" href=\"?page={$next}\" aria-label=\"Next\">
                        <span aria-hidden=\"true\">&raquo;</span>
                        <span class=\"sr-only\">Next</span>
                      </a>
                    </li>";
           $links .= "<li class=\"page-item\"><a class=\"page-link\" href=\"?page={$this->pages}\">[{$this->pages}]</a></li>";

           return $links;
       }

   }

   public function links()
   {
       if($this->page > 0){

           $links = "<nav aria-label=\"Page navigation example\">
                        <ul class=\"pagination\">";

           $links.= $this->previous();

           for($i = $this->page - $this->maxLinks;$i <= $this->page + $this->maxLinks;$i++){
              $active = ($this->page == $i) ? "active" : "";
              if($i > 0 && $i <= $this->pages){
                  $links .=  "<li class=\"page-item {$active}\"><a class=\"page-link \" href=\"?page={$i}\">{$i}</a></li>";

              }
           }

           $links.= $this->next();
           $links.=     "</ul>
                    </nav>";

           return $links;
       }
   }
}