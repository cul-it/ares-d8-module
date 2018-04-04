<?php
/**
 * @file
 * Contains \Drupal\ares\Form\AresListForm.
 */
namespace Drupal\ares\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class aresListForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ares_list_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $courseJSON = $this->get_courses_json('Music');
    $courses = json_decode($courseJSON, true);
    $course_ids = array_map(array($this, 'mapCourseKeys'), $courses['courseList']);
    $course_labels = array_map(array($this, 'mapCourses'), $courses['courseList']);
    $course_options_hash = array_combine($course_ids, $course_labels);
    asort($course_options_hash);
    $form['course_select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select course'),
      '#options' => $course_options_hash,
    );
    $form['reserve_list'] = array(
      '#markup' => '<table id="reserve-list" class="tablesorter"></table>'
    );
    $form['#attached']['library'][] = 'ares/ares-selector';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Your form is being submitted!'));
  }

  /**
   * Call get_courses_json() via URL, return JSON.
   *
   */
  function get_courses_json($library) {
    //global $courses_url;
    $courses_url = 'http://mannservices.mannlib.cornell.edu/LibServices/showCourseReserveList.do?output=json&library=';
    // static $ares_courses_json;
    $cid = 'ares_courses_' . $library;
    $url = $courses_url . $library;
    // $ares_courses_json = get_and_cache_json($cid, $url);
    // output_json_string($ares_courses_json);
    $result = file_get_contents($url);

    return $result;
  }

  function mapCourseKeys($course) {
    return $course['id'];
  }

  function mapCourses($course) {
  //  dpm($course, 'course');
    $label = $course['courseNumber'] . ': ' . $course['courseName'];
    if (!ctype_space($course['classCode']) && $course['classCode'] != '') {
      $label .= ' (Section ' . $course['classCode'] . ')';
    }
    elseif ($course['semester'] == 'Permanent Reserve') {
      $label .= ' (Permanent Reserve)';
    }
    return $label;
  }

}
