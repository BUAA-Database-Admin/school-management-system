<?php
foreach (array('teacher', 'student') as $tab) {
    echo <<<HTML
<div class="tab-pane fade" id="add-{$tab}">
  <form id="add-{$tab}-form">
    <div class="form-group row">
      <label for="{$tab}-id" class="col-xs-2 col-form-label">ID</label>
      <div class="col-xs-10">
        <input class="form-control" type="number" value="" id="{$tab}-id">
      </div>
    </div>
    <div class="form-group row">
      <label for="{$tab}-name" class="col-xs-2 col-form-label">Name</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" value="" id="{$tab}-name">
      </div>
    </div>
    <div class="form-group row">
      <label for="{$tab}-age" class="col-xs-2 col-form-label">Age</label>
      <div class="col-xs-10">
        <input class="form-control" type="number" value="" id="{$tab}-age">
      </div>
    </div>
    <div class="form-group row">
      <label for="{$tab}-sex" class="col-xs-2 col-form-label">Sex</label>
      <div class="col-xs-10">
        <select class="form-control" id="{$tab}-sex">
          <option>Male</option>
          <option>Female</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="{$tab}-dept_id" class="col-xs-2 col-form-label">Department</label>
      <div class="col-xs-10">
        <select class="form-control" id="{$tab}-dept_id">
HTML;
    $depts = Department::newInstances(null);
    foreach ($depts as $dept) {
        echo <<<HTML
          <option value="{$dept->id}">{$dept->name}</option>
HTML;
    }
    echo <<<HTML
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="{$tab}-password" class="col-xs-2 col-form-label">Password</label>
      <div class="col-xs-10">
        <div class="input-group">
          <input class="form-control" type="password" id="{$tab}-password" aria-describedby="vis" required>
          <span class="input-group-btn" id="vis">
            <button class="btn btn-secondary" type="button">
              <i class="fa fa-eye" aria-hidden="true"></i>
            </button>
          </span>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary float-xs-right">Submit</button>
  </form>
</div>
HTML;
}
