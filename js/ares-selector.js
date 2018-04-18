(function($, Drupal, drupalSettings) {
  Drupal.behaviors.aresSelectorClick = {
    attach: function(context, settings) {
      $('#edit-course-select').change(function(preset) {
        var courseId = $('#edit-course-select').val();
        var url = 'https://mannservices.mannlib.cornell.edu/LibServices/showCourseReserveItemInfo.do?output=json&courseid=' + courseId;

        // If this is the front-page block, we DON'T want to show the
        // entire reserve list in situ. Instead, redirect to the course
        // reserves page
        if ($('body').hasClass('path-frontpage')) {
          window.location = "course-reserves?courseId=" + courseId;
          return;
        }

        $('#reserve-list').html('Loading reserve list ...');

        $.getJSON(url, function(result) {
          // console.log("got back items", result.reserveItemList);
          var reserveTable = '<thead><tr class="header"><th>Item</th><th>Author</th><th>Call number</th><th>Due back</th></tr></thead>';
          reserveTable += '<tbody>';
          var odd_even = 'odd';

          $.each(result.reserveItemList, function(i, reserve) {
            ((i+1)%2) == 0  ? odd_even = 'even' : odd_even = 'odd';
            reserveTable += '<tr class="' + odd_even + '">';

            // TITLE AND PAGES
            reserveTable += '   <td class="ares-title">';
            if (reserve.articleTitle != '' && reserve.articleTitle != '?') {
              reserveTable +=  '<p class="title"><strong>' + reserve.title + '</strong></p>';
              reserveTable +=  '<p class="article-title"><em>' + reserve.articleTitle + '</em></p>';
            } else {
              reserveTable +=  '<p class="title"><strong>' + reserve.title + '</strong></p>';
            }

            // Originally this showed pages for all formats, but it was requested
            // by Wendy and Troy to limit it to articles and chapters only
            if ((reserve.itemFormat == 'Article' || reserve.itemFormat == 'BookChapter') && (reserve.pages != '' && reserve.pages != '?')) {
              reserveTable +=  '<p class="pages">pp. ' + reserve.pages + '</p>';
            }
            reserveTable += '</td>';

            // AUTHOR
            reserveTable += '   <td class="ares-author"><p>' + reserve.author + '</p></td>';

            // BLACKBOARD LINK OR LIBRARY AND CALLNUMBER
            reserveTable += '   <td class="ares-location-complete">';
            if (reserve.status.toUpperCase().indexOf("ELECTRONIC") != -1) {
              reserveTable += '<p class="electronic">Electronic Access: <a href="http://blackboard.cornell.edu/#aresid=' + reserve.id + '">Click here to find electronic reserve readings in Blackboard</a></p>';
            } else {
              if (reserve.location != '' && reserve.location != '?') {
                reserveTable += '<p class="ares-location">' + reserve.location + '&nbsp;</p>';
              }
              reserveTable += '<p class="ares-callnumber">' + reserve.callnumber + '</p></td>';
            }
            reserveTable += '</td>';

            // DUE DATE
            // Convert date format to MM/DD/YYYY HH:MM
            reserve.dueDate = reserve.dueDate.replace(/(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}).*/, '$2/$3/$1 $4');
            var formattableDate = moment(reserve.dueDate);
            var formattedDate;

            if (formattableDate.isValid())
              formattedDate = moment(reserve.dueDate).format('ddd, M/D/YY [ &nbsp;&nbsp; ] h:mm A');
            else
              // If formattableDate is *not* a valid date, then it's probably a status
              // message like 'Available' that should be passed through without alteration.
              formattedDate = reserve.dueDate;

            if (reserve.status.toUpperCase().indexOf("ELECTRONIC") == -1) {
              reserveTable += '   <td class="ares-status"><span class="available">' + formattedDate + '</span></td>';
            } else {
              reserveTable += '   <td class="ares-status"></td>';
            }

            reserveTable += '</tr>';

          });
          reserveTable += '</tbody>';
          $('#reserve-list').html(reserveTable);
          $('#reserve-list').tablesorter();

        });
      });
      if (!$('body').hasClass('path-frontpage')) {
        // If this is the course reserves page, look to see whether a courseId is
        // specified in the URL. If so, set the select list to that value and
        // trigger the onChange handler. (This is used by the front-page block
        // as a redirect method.)
        var urlParams = new URLSearchParams(window.location.search);
        var courseId = urlParams.get('courseId');
        if (courseId) {
          $('#edit-course-select').val(courseId);
          $('#edit-course-select').change();
        }
      }
    }
  };
})(jQuery, Drupal, drupalSettings);
