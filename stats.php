<?php

// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';
$pageName = "Designer Agents";
$pageURL = "http://designeragents.com/";
$VIEW_ID = "125697624";

$analytics = initializeAnalytics();
$hitsAllTime = getAllHits($analytics,$VIEW_ID);
$hitsLastMonth = getMonthIndividualHits($analytics,$VIEW_ID);
$hitsLastWeek = getWeekIndividualHits($analytics,$VIEW_ID);
$hitsYesterday = getYesterdayHits($analytics,$VIEW_ID);
$usersAllTime = getAllUsers($analytics,$VIEW_ID);
$usersLastMonth = getMonthIndividualUsers($analytics,$VIEW_ID);
$usersLastWeek = getWeekIndividualUsers($analytics,$VIEW_ID);
$usersYesterday = getYesterdayIndividualUsers($analytics,$VIEW_ID);
$newUsersAllTime = getAllNewUsers($analytics,$VIEW_ID);
$newUsersLastMonth = getMonthIndividualNewUsers($analytics,$VIEW_ID);
$newUsersLastWeek = getWeekIndividualNewUsers($analytics,$VIEW_ID);
$newUsersYesterday = getYesterdayNewUsers($analytics,$VIEW_ID);

print("<a href=\"" . $pageURL . "\">"$pageName . "</a> - Rudimentary Page Statistics:<br/>");
printResults($hitsAllTime);
print("<br/>");
printResults($hitsLastMonth);
print("<br/>");
printResults($hitsLastWeek);
print("<br/>");
printResults($hitsYesterday);
print("<br/><br/>");
printResults($usersAllTime);
print("<br/>");
printResults($usersLastMonth);
print("<br/>");
printResults($usersLastWeek);
print("<br/>");
printResults($usersYesterday);
print("<br/><br/>");
printResults($newUsersAllTime);
print("<br/>");
printResults($newUsersLastMonth);
print("<br/>");
printResults($newUsersLastWeek);
print("<br/>");
printResults($newUsersYesterday);
print("<br/><br/>");
print("Provided Care of <a href=\"https://analytics.google.com\">Google Analytics and Google Analytics API</a>");

function initializeAnalytics()
{
  // Creates and returns the Analytics Reporting service object.

  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Hello Analytics Reporting");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  $analytics = new Google_Service_AnalyticsReporting($client);

  return $analytics;
}

function getAllUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("2016-07-01");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:users");
  $sessions->setAlias("Individual Users - All Time");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getMonthIndividualUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("30daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:users");
  $sessions->setAlias("Individual Users - This Month");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getWeekIndividualUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:users");
  $sessions->setAlias("Individual Users - This Week");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getYesterdayIndividualUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("1daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:users");
  $sessions->setAlias("Individual Users - Yesterday");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}


function getAllNewUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("2016-07-01");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:newUsers");
  $sessions->setAlias("New Users - All Time");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getMonthIndividualNewUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("30daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:newUsers");
  $sessions->setAlias("New Users - This Month");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getWeekIndividualNewUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:newUsers");
  $sessions->setAlias("New Users - This Week");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getYesterdayNewUsers(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("1daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:newUsers");
  $sessions->setAlias("New Users - Yesterday");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getAllHits(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("2016-07-01");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:hits");
  $sessions->setAlias("All Hits");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getMonthIndividualHits(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("30daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:hits");
  $sessions->setAlias("Hits This Month");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getWeekIndividualHits(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:hits");
  $sessions->setAlias("Hits This Week");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getYesterdayHits(&$analytics,$VIEW_ID) {

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $VIEW_ID;

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("1daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:hits");
  $sessions->setAlias("Hits - Yesterday");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function printResults(&$reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
      for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
        print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
      }

      for ($j = 0; $j < count( $metricHeaders ) && $j < count( $metrics ); $j++) {
        $entry = $metricHeaders[$j];
        $values = $metrics[$j];
        //print("Metric type: " . $entry->getType() . "\n" );
        for ( $valueIndex = 0; $valueIndex < count( $values->getValues() ); $valueIndex++ ) {
          $value = $values->getValues()[ $valueIndex ];
          print($entry->getName() . ": " . $value . "\n");
        }
      }
    }
  }
}

