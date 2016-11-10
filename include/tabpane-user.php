<div class="modal fade" id="course-info" tabindex="-1" role="dialog" aria-labelledby="course-info-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="course-info-label">Course Information</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Teacher</th>
              <th>Credit</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row" name="id"></th>
              <td name="name"></td>
              <td name="teacher"></td>
              <td name="credit"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="tab-pane fade" id="person-info">
  <form id="person-info-form">
    <div class="form-group row">
      <label for="person-info-name" class="col-xs-2 col-form-label">Name</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" value="<?php echo $user->name; ?>" id="person-info-name">
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-age" class="col-xs-2 col-form-label">Age</label>
      <div class="col-xs-10">
        <input class="form-control" type="number" value="<?php echo $user->age; ?>" id="person-info-age">
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-sex" class="col-xs-2 col-form-label">Sex</label>
      <div class="col-xs-10">
        <select class="form-control" id="person-info-sex">
          <option<?php echo $user->sex == 'Male' ? ' selected' : ''; ?>>Male</option>
          <option<?php echo $user->sex == 'Female' ? ' selected' : ''; ?>>Female</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-email" class="col-xs-2 col-form-label">Email</label>
      <div class="col-xs-10">
        <input class="form-control" type="email" value="<?php echo $user->contact->email; ?>" id="person-info-email">
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-telephone" class="col-xs-2 col-form-label">Landline</label>
      <div class="col-xs-10">
        <input class="form-control" type="tel" value="<?php echo $user->contact->telephone; ?>" id="person-info-telephone">
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-mobile" class="col-xs-2 col-form-label">Mobile</label>
      <div class="col-xs-10">
        <input class="form-control" type="tel" value="<?php echo $user->contact->mobile; ?>" id="person-info-mobile">
      </div>
    </div>
    <div class="form-group row">
      <label for="person-info-password" class="col-xs-2 col-form-label">Password</label>
      <div class="col-xs-10">
        <div class="input-group">
          <input class="form-control" type="password" id="person-info-password" aria-describedby="vis">
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
