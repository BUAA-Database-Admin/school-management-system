<div class="tab-pane fade" id="add-course">
  <form id="add-course-form">
    <div class="form-group row">
      <label for="course-name" class="col-xs-2 col-form-label">Name</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" value="" id="course-name">
      </div>
    </div>
    <div class="form-group row">
      <label for="course-user_id" class="col-xs-2 col-form-label">Teacher</label>
      <div class="col-xs-10">
        <select class="form-control" id="course-user_id">
<?php
$teachers = User::newInstances(array('role' => 'Teacher'));
foreach ($teachers as $teacher) {
    echo <<<HTML
          <option value="{$teacher->id}">{$teacher->name}</option>
HTML;
}
?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="course-credit" class="col-xs-2 col-form-label">Credit</label>
      <div class="col-xs-10">
        <input class="form-control" type="number" value="" id="course-credit">
      </div>
    </div>
    <button type="submit" class="btn btn-primary float-xs-right">Submit</button>
  </form>
</div>
<div class="tab-pane fade" id="add-department">
  <form id="add-dept-form">
    <div class="form-group row">
      <label for="dept-name" class="col-xs-2 col-form-label">Name</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" value="" id="dept-name">
      </div>
    </div>
    <button type="submit" class="btn btn-primary float-xs-right">Submit</button>
  </form>
</div>