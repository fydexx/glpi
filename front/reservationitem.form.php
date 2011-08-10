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
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

define('GLPI_ROOT', '..');
include (GLPI_ROOT . "/inc/includes.php");

checkCentralAccess();

$ri = new ReservationItem();

if (isset($_REQUEST["add"])) {
   checkRight("reservation_central","w");
   if ($newID = $ri->add($_REQUEST)) {
      Event::log($newID, "reservationitem", 4, "inventory",
                 $_SESSION["glpiname"]." ".$LANG['log'][20]." ".$_REQUEST["itemtype"]."-".
                     $_REQUEST["items_id"].".");
   }
   Html::header();

} else if (isset($_REQUEST["delete"])) {
   checkRight("reservation_central","w");
   $ri->delete($_REQUEST);
   Event::log($_REQUEST['id'], "reservationitem", 4, "inventory",
              $_SESSION["glpiname"]." ".$LANG['log'][22]);
   Html::header();

} else if (isset($_REQUEST["update"])) {
   checkRight("reservation_central","w");
   $ri->update($_REQUEST);
   Event::log($_REQUEST['id'], "reservationitem", 4, "inventory",
              $_SESSION["glpiname"]." ".$LANG['log'][21]);
   Html::header();

} else {
   checkRight("reservation_central","w");
   commonHeader($LANG['Menu'][17], $_SERVER['PHP_SELF'], "utils", "reservation");
   $ri->showForm($_GET["id"]);
}

commonFooter();

?>