        <form action="<?=base_url('register')?>" method="POST">
            <fieldset style="margin-bottom: 1rem; border-width: 0px;">
                <h4 class="text-center">Camp Registeration</h4>
                <div class="mb-3">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="" required aria-describedby="first name">
                </div>
                <div class="mb-3">
                    <label for="lname">Last Name(Surname)</label>
                    <input type="text" name="lname" id="lname" class="form-control" placeholder="" required aria-describedby="Last name">
                </div>
                <div class="mb-3">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option>Select a gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tc">Training Circle</label>
                    <select name="tc" id="tc" class="form-control" required>
                        <option value="">Select a TC</option>
                        <option value="Abeokuta South">Abeokuta South</option>
                        <option value="Abeokuta North">Abeokuta North</option>
                        <option value="Aiyetoro">Aiyetoro</option>
                        <option value="Ilaro">Ilaro</option>
                        <option value="Owode">Owode</option>
                        <option value="Elega">Elega</option>
                        <option value="Onikolobo">Onikolobo</option>
                        <option value="TYLF">TYLF</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" placeholder="" required aria-describedby="Age">
                </div>
                <div class="mb-3">
                    <label for="schoolcls">School Class</label>
                    <input type="text" name="schoolcls" id="schoolcls" class="form-control" placeholder="" required aria-describedby="School Class">
                </div>
                <div class="mb-3">
                    <label for="phone">Parent Phone Number</label>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="" required aria-describedby="Phone Number">
                    <input type="hidden"  name="ref" value=<?=$ref?> >

                </div>
                <div class="mb-3">
                    <label for="address">Contact Address</label>
                    <input type="address" name="address" id="address" class="form-control" placeholder="" required aria-describedby="Address">
                </div>
                <div class="mb-3">
                    <label for="ailment">Any Ailment? Ignore if none</label>
                    <input type="ailment" name="ailment" id="ailment" value="None" class="form-control" placeholder="" required aria-describedby="ailment">
                </div>
                <div class="text-center form-check form-check-inline">
                      <input type="checkbox" class="form-check-input" disabled id="lcamp">
                      <label class="form-check-label" for="lcamp">
                        I (the parent or guradian of <b id="v-fname"></b>) confirmed that the data provided above is correct.
                      </label>
                </div>
        </div>
        <div class="text-center" id="btn2">
            <button type="submit" class="btn btn-success" disabled id="reg">Confirm Registeration</button>
        </div>
        </form>

<script>
    document.querySelector('#fname').addEventListener('blur', ()=>{
        document.querySelector('#v-fname').innerText = document.querySelector('#fname').value;
        if(document.querySelector('#fname').value){
            document.querySelector('#lcamp').disabled = false;
        }else{
            document.querySelector('#lcamp').disabled = true;
        }
    })
    document.querySelector('#lcamp').addEventListener('change', ()=>{
        if(document.querySelector('#lcamp').checked){
            document.querySelector('#reg').disabled = false;
        }else{
            document.querySelector('#reg').disabled = true;
        }
    })
</script>