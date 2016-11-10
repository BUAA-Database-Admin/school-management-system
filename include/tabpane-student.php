<?php include __DIR__ . '/tabpane-user.php'; ?>
<div class="tab-pane fade" id="select-courses">
  <form id="select-courses-form">
    <table class="table table-hover">
      <thead class="thead-inverse">
        <tr>
          <th>ID</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
<?php
$user->joinCourseSelections();
$courses = Course::newInstances(null);
foreach ($courses as $course) {
    if (in_array($course->id, array_keys($user->cs_list))) {
        continue;
    }
    echo <<<HTML
        <tr>
          <th scope="row">{$course->id}</th>
          <td><a name="view-course-info" href="#" data-toggle="modal" data-target="#course-info">{$course->name}</a></td>
        </tr>
HTML;
}
?>
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary float-xs-right">Submit</button>
  </form>
</div>
<div class="tab-pane fade" id="view-courses">
  <table class="table table-hover">
    <thead class="thead-inverse">
      <tr>
        <th>ID</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
<?php
$cum_grade = 0;
foreach ($user->cs_list as $cs) {
    if ($cs->grade != -1) {
        $cum_grade += $cs->grade;
    }
    $course = Course::newInstance(array('id' => $cs->course_id));
    echo <<<HTML
      <tr>
        <th scope="row">{$course->id}</th>
        <td><a name="view-course-info" href="#" data-toggle="modal" data-target="#course-info">{$course->name}</a></td>
      </tr>
HTML;
}
?>
    </tbody>
  </table>
</div>
<div class="tab-pane fade" id="check-grade">
  <div class="card card-block">
    <div class="mb-1">
      <h4 class="card-title d-inline">Cumulative Grade: </h4>
      <span class="card-text text-danger float-xs-right"><strong><?php echo $cum_grade; ?></strong></span>
    </div>
    <a href="#" class="btn btn-primary float-xs-right" data-toggle="modal" data-target="#grade-detail">Show Details</a>
  </div>
  <div class="modal fade" id="grade-detail" tabindex="-1" role="dialog" aria-labelledby="grade-detail-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          <h4 class="modal-title" id="grade-detail-label">Details</h4>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
            <thead class="thead-inverse">
              <tr>
                <th>Name</th>
                <th>Grade</th>
              </tr>
            </thead>
            <tbody>
<?php
foreach ($user->cs_list as $cs) {
    if ($cs->grade == -1) {
        continue;
    }
    $course = Course::newInstance(array('id' => $cs->course_id));
    echo <<<HTML
              <tr>
                <th scope="row">{$course->name}</th>
                <td>{$cs->grade}</td>
              </tr>
HTML;
}
?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
