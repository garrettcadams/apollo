<?php

/**
 * THESE ARE FUNCTIONS RELATED TO TRIBE EVENTS CALENDAR.
 * UNCOMMENT AS NEEDED OR DELETE THIS FILE IF EVENTS NOT USED.
 * -----
 * IT'S A RAG TAG BUNCH OF FUNCTIONS :: USE AT YOUR OWN RISK!!!
 */

// // Hide Google Links
//  add_filter( 'tribe_event_meta_gmap_link', '__return_empty_string' );

//  // Replace Default Tribe Events Stylesheets with main
//  // function replace_tribe_events_calendar_stylesheet() {
//  //    $styleUrl = get_bloginfo('template_url') . '/assets/css/main.min.css';
//  //    return $styleUrl;
//  // }
//  // add_filter('tribe_events_stylesheet_url', 'replace_tribe_events_calendar_stylesheet');

//  if(WP_ENV !== 'development') {
//   // Reverse Past Events
//   function tribe_past_reverse_chronological ($post_object) {
//      $past_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX && $_REQUEST['tribe_event_display'] === 'past') ? true : false;
//      if(tribe_is_past() || $past_ajax) {
//          $post_object = array_reverse($post_object);
//      }
//      return $post_object;
//   }
//   add_filter('the_posts', 'tribe_past_reverse_chronological', 100);
//   add_action('tribe_events_before_template', 'remove_ical_from_list_view');
// }

// // Remove all iCal Links
// function remove_ical_from_list_view() {
// if (tribe_is_event_query() && tribe_is_list_view())
//   remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }
// add_action('tribe_events_before_template', 'remove_ical_from_month_view');

// function remove_ical_from_month_view() {
// if (tribe_is_event_query() && tribe_is_month())
//   remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }

// add_action('tribe_events_before_view', 'remove_ical_from_org_venue_views');
// function remove_ical_from_org_venue_views() {
// if ( tribe_is_event_query() && (tribe_is_organizer() || tribe_is_venue()) )
//   remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }

// add_action('tribe_events_single_event_before_the_content', 'tribe_remove_single_event_links');

// function tribe_remove_single_event_links () {
//   remove_action( 'tribe_events_single_event_after_the_content', array( 'TribeiCal', 'single_event_links' ) );
// }

// // Mini Calendar
// add_filter('tribe_events_the_previous_month_link', 'change_prev_link');
// // add_filter('tribe_events_the_mini_calendar_prev_link', 'change_prev_link');
// function change_prev_link($html) {
//   $start = strpos($html, '>')+1;
//   $end = strpos($html, '</a>');
//   $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-left"></i>' . substr($html, $end);
//   return $html;
// }

// add_filter('tribe_events_the_next_month_link', 'change_next_link');
// // add_filter('tribe_events_the_mini_calendar_next_link', 'change_next_link');
//   function change_next_link($html) {
//   $start = strpos($html, '>')+1;
//   $end = strpos($html, '</a>');
//   $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-right"></i>' . substr($html, $end);
//   return $html;
// }

// // add_filter('tribe_events_get_days_of_week', 'change_days_of_week');
// // function change_days_of_week($days) {
// //   return array('S', 'M', 'T', 'W', 'T', 'F','S');
// //   return $days;
// // }

// remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'));//array('TribeiCal', 'init'));