(function($, Drupal) {
  Drupal.behaviors.aresSelectorClick = {
    attach: function(context, settings) {
      $('#edit-course-select').change(function() {
        var courseId = $('#edit-course-select').val();
        var url = 'http://mannservices.mannlib.cornell.edu/LibServices/showCourseReserveItemInfo.do?output=json&courseid=' + courseId;

        $.getJSON(url, function(result) {
          console.log("got back items", result.reserveItemList);
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
    }
  };
})(jQuery, Drupal, drupalSettings);
