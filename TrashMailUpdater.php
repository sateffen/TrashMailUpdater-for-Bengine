<?php
/*
 *  Copyright (C) 2012 sateffen
 *  https://github.com/sateffen/TrashMailUpdater-for-Bengine
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Bengine_Cronjob_TrashMailUpdater extends Recipe_CronjobAbstract
{
        /**
         * Updates the Trashmailist
         */
        protected function updateTrashMailList()
        {
                $domainList = file( 'http://www.mogelmail.de/export_txt.php' , FILE_SKIP_EMPTY_LINES ) ;
                
                foreach ( $domainList as $k => $domain )
                {
                    $domain = str_replace( array('"',"'",'!','§','$','%','/','\\','(',')','[',']','=','{','}','#','*','+','-') , '' , $domain );
                    $domainList[$k] = '@' . trim( $domain );
                }
                
                $domainList = mysql_real_escape_string( implode( ',' , $domainList ) );
                Core::getOptions()->setValue( 'BANNED_EMAILS' , $domainList , true );
        }

        /**
         * Executes this cronjob.
         *
         * @return Bengine_Cronjob_TrashMailUpdater
         */
        protected function _execute()
        {
                $this->updateTrashMailList();
                return $this;
        }
}
?>	
