
        <div class="progress-container">
            <div class="progress" id="progress"></div>
            <div class="circle active">1</div>
            <div class="circle">2</div>
            <div class="circle">3</div>
            <!-- <div class="circle">4</div> -->
        </div>
        <form action="<?=base_url('register')?>" method="POST">
        <div class="fieldset" id="one">

            <fieldset class="d-none d-block" style="margin-bottom: 1rem; border-width: 0px;">
                <h4>Personal Details</h4>
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="" required aria-describedby="first name" value="<?=$udata['fname']?>">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" id="lname" class="form-control" placeholder="" required aria-describedby="Last name" value="<?=$udata['lname']?>">
                </div>
                <div class="mb-3">
                    <label for="lb" class="form-label">Local Branch</label>
                    <select name="lb" id="lb" required>
                        <option value="">Select a Local Branch</option>
                        <option class="lb" value="Egba">Egba</option>
                        <option class="lb" value="Remo">Remo</option>
                        <option class="lb" value="Ijebu">Ijebu</option>
                        <option class="lb" value="Adoodo">Ado-Odo</option>
                        <option class="lb" value="others">Others</option>
                    </select>
                </div>
                <div id="lcamp"></div>
            </fieldset>
        </div>
        <div class="fieldset" id="two">
            <fieldset class="d-none" style="margin-bottom: 1rem; border-width: 0px;">
                <h4>Contact Details</h4>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" required value="<?=$udata['gender']?>">
                        <option>Select a gender</option>
                        <option class="gend" value="male">Male</option>
                        <option class="gend" value="female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="" required aria-describedby="Phone Number" value="<?=$udata['phone']?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="" required aria-describedby="Email" value="<?=$udata['email']?>">
                </div>
            </fieldset>
        </div>
        <div class="fieldset" id="three">
            <fieldset class="d-none" style="margin-bottom: 1rem; border-width: 0px;">
                <h4>Work/School Details</h4>
                <div class="mb-3">
                    <label for="org" class="form-label">Which Islamic org. do you belong to?</label>
                    <select name="org" id="org" required>
                        <option>Choose an Organisation</option>
                        <option value="phf">PHF</option>
                        <option value="tym">TYMa</option>
                        <option value="tym">TYLF</option>
                        <option value="mssn">MSSN</option>
                        <option value="nasfat">NASFAT</option>
                        <option value="aud">Ansaru-Deen</option>
                        <option value="tmc">TMC</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" required value="<?=$udata['category']?>">
                        <option>Select a Category</option>
                        <option class="catg" value="primary">Primary School</option>
                        <option class="catg" value="jsec">Junior Secondary</option>
                        <option class="catg" value="ssec">Senior Secondary</option>
                        <option class="catg" value="sch_leaver">School Leaver</option>
                        <option class="catg" value="hi">Higher Institution</option>
                        <option class="catg" value="Workers">Worker</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sch" class="form-label">School/Course/Profession</label>
                    <input type="sch" name="school" required id="sch" class="form-control" placeholder="" aria-describedby="sch" value="<?=$udata['school']?>">
                    <input type="hidden"  name="ref" value="<?=$ref?>" >
                    <input type="hidden"  name="old" value="<?=$udata['id']?>" >
                </div>
                <div class="text-center form-check form-check-inline">
                      <input type="checkbox" class="form-check-input" id="transfer">
                      <label class="form-check-label" for="transfer">
                        All data provided are correct and accurate
                      </label>
                </div>
            </fieldset>
        </div>
        <div class="text-center" id="btn1">
            <button type="button" class="btn" disabled id="prev">Prev</button>
            <button type="button" class="btn" id="next">Next</button>
        </div>
        <div class="text-center d-none" id="btn2">
            <button type="submit" class="btn btn-success" id="reg">Confirm Registeration</button>
        </div>
        </form>
<script>
    document.querySelector('#lb').selectedIndex = Array.from(document.querySelectorAll('.lb'),x=>x.value).indexOf('<?=$udata['lb']?>')+1;
    document.querySelector('#gender').selectedIndex = Array.from(document.querySelectorAll('.gend'),x=>x.value).indexOf('<?=$udata['gender']?>')+1;
    document.querySelector('#category').selectedIndex = Array.from(document.querySelectorAll('.catg'),x=>x.value).indexOf('<?=$udata['category']?>')+1;
</script>
