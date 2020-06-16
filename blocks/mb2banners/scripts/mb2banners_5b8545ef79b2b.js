// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package		Mb2 Banners
 * @author		Mariusz Boloz (http://mb2extensions.com)
 * @copyright	Copyright (C) 2018 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		Commercial (http://codecanyon.net/licenses)
**/
jQuery(document).ready(function($){


   $('.mb2banners-withcookie').each(function(){

      var banner = $(this);
      var cookie_name = 'mb2banners' + banner.data('mb2banners_id');
      var cookie_expiry = banner.data('mb2banners_cookieexpiry');
      var cookie_options = {expires: cookie_expiry, path: '/'};
      var close_btn = banner.find('.mb2banners-close');


      if (banner.hasClass('show') || Cookies.get(cookie_name) !== 'hide')
      {
         banner.show();
      }


      close_btn.click(function(e){

         e.preventDefault();
         if (!banner.hasClass('show'))
         {
            banner.slideUp(250);
            Cookies.set(cookie_name,'hide',cookie_options);
         }


      });


   });


});
