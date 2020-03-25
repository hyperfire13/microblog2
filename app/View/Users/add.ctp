<!-- app/View/Users/add.ctp -->
<div class="col-lg-12">
	<?php echo $this->Form->create('User'); ?>
		
		<div class="card text-white bg-info mb-3">
			<div class="card-header">Signup</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="inputDefault">Username</label>
							<input type="text" name="username" class="form-control" placeholder="Enter username" id="Enter username" >
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Confirm Password</label>
							<input type="password" name="confirm_password" class="form-control" id="password" placeholder="Confirm Password" required>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="col-form-label" for="inputDefault">Firstname</label>
							<input type="text" name="first_name" class="form-control" placeholder="Enter firstname" id="first_name" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="inputDefault">Middlename</label>
							<input type="text" name="middle_name" class="form-control" placeholder="Enter middlename" id="middle_name" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="inputDefault">Lastname</label>
							<input type="text" name="last_name" class="form-control" placeholder="Enter lastname" id="last_name" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="inputDefault">Birthday</label>
							<input type="date" name="date_of_birth" class="form-control" placeholder="Enter birthday" id="date_of_birth" required>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<button type="submit" class="btn btn-primary">Submit</button>
		
	<?php echo $this->Form->end(__('Submit')); ?>
</div>