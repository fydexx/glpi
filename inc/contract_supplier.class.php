<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Julien Dombre
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

// Relation between Contracts and Suppliers
class Contract_Supplier extends CommonDBRelation {

   // From CommonDBRelation
   public $itemtype_1 = 'Contract';
   public $items_id_1 = 'contracts_id';

   public $itemtype_2 = 'Supplier';
   public $items_id_2 = 'suppliers_id';


   static function countForSupplier(Supplier $item) {

      $restrict = "`glpi_contracts_suppliers`.`suppliers_id` = '".$item->getField('id') ."'
                    AND `glpi_contracts_suppliers`.`contracts_id` = `glpi_contracts`.`id` ".
                    getEntitiesRestrictRequest(" AND ", "glpi_contracts", '',
                                               $_SESSION['glpiactiveentities']);

      return countElementsInTable(array('glpi_contracts_suppliers', 'glpi_contracts'), $restrict);
   }


   function getTabNameForItem(CommonGLPI $item) {
      global $LANG;

      if ($item->getID() && haveRight("contract","r")) {
         if ($_SESSION['glpishow_count_on_tabs']) {
            return self::createTabEntry($LANG['Menu'][25], self::countForSupplier($item));
         }
         return $LANG['Menu'][25];
      }
      return '';
   }


   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      $item->showContracts();
      return true;
   }

}
?>
