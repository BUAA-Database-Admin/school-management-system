<?php include __DIR__ . '/tabpane-user.php'; ?>
<div class="tab-pane fade" id="view-course">
  <table class="table table-hover">
    <thead class="thead-inverse">
      <tr>
        <th>ID</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
<?php
$user->joinCourses();
foreach ($user->courses as $course) {
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
<div class="tab-pane fade" id="modify-grade">
  <div class="btn-group" role="group">
    <button id="dropdown-courses" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      Select Courses
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdown-courses">
<?php
foreach ($user->courses as $course) {
    echo <<<HTML
      <a class="dropdown-item" data-toggle="tab" href="#course-{$course->id}">{$course->name}</a>
HTML;
}
?>
    </div>
  </div>
  <div class="container tab-content mt-1">
<?php
foreach ($user->courses as $course) {
    echo <<<HTML
    <div class="tab-pane fade" id="course-{$course->id}">
      <form name="modify-grade-form">
        <table class="table table-hover">
          <thead class="thead-inverse">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody>
HTML;
    $cs_list = CourseSelection::newInstances(array('course_id' => $course->id));
    foreach ($cs_list as $cs) {
        $user = User::newInstance(array('id' => $cs->user_id));
        echo <<<HTML
            <tr>
              <th scope="row">{$user->id}</th>
              <td>{$user->name}</td>
              <td>
                <input type="number" class="form-control" value="{$cs->grade}">
              </td>
            </tr>
HTML;
    }
    echo <<<HTML
          </tbody>
        </table>
        <button type="submit" class="btn btn-primary float-xs-right">Submit</button>
      </form>
    </div>
HTML;
}
?>
  </div>
</div>
