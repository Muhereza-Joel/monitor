@include('partials/header')

<style>
  #progress-bar-container {
    display: flex;
    width: 100%;
    text-align: center;
    margin-top: 10px;
  }

  #progress-bar {
    width: 100%;
    height: 10px;
  }

  #progress-percentage {
    display: inline-block;
    margin-top: 5px;
    color: #000;
  }
</style>

<body>

  <main>
    <div class="container px-4">
      <!-- Profile Edit Form -->
      <form class="needs-validation card mt-5" novalidate id="create-profile-form" enctype="multipart/form-data">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-xl-10 col-md-10 d-flex flex-column align-items-center justify-content-center">


                <img src="/{{$appName}}/assets/img/logo_yellow.png" alt="logo" style="width: 400px;">
                <h1>{{$appNameFull}}</h1>
                <br><br>
                <h4 class="pt-2">Hello, <span class="text-success">{{$username}}</span> take a breath add complete your profile</h4>
                <h5>Adding your profile helps us to know you better, you profile information is used to tag responses.</h5>
                <p>Please note that your the only person who can change your profile, and none of this data will be shared without your consent.</p>

              </div>
              <hr class="w-75">
            </div>

            <section class="section profile">
              <div class="row">

                <div class="col-xl-5">

                  <div class="text-center">
                    <img id="profile-photo" src="/{{$appName}}/assets/img/avatar.png" class="rounded-circle" alt="Profile" width="250px" height="250px" style="border: 3px solid #999; object-fit: cover;">

                  </div>
                  <div class="">
                    <div class=" profile-card pt-4 d-flex flex-column align-items-center">

                      <div class="row mb-3">

                        <div class="col-md-12 col-lg-12 d-flex flex-column align-items-center justify-content-center">

                          <div class="pt-2">
                            <input type="hidden" name="image_url" id="image_url">

                            <br>
                            <input type="file" name="image" id="image" class="btn btn-outline btn-sm" required accept="image/jpeg">
                            <div class="invalid-feedback">Please choose a profile photo</div>
                          </div>
                          <div id="progress-bar-container" style="display: none;">
                            <progress id="progress-bar" value="0" max="100"></progress>
                            <span id="progress-percentage">0%</span>
                          </div>



                        </div>
                      </div>

                    </div>
                  </div>

                  <div class=" p-2">


                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Your Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input oninput="capitalizeEveryWord(this)" name="fullName" type="text" class="form-control" id="fullName" placeholder="Enter your full name here" required>
                        <div class="invalid-feedback">Please enter your full name.</div>
                      </div>
                    </div>



                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Where do you work (Optional)</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control" id="company" placeholder="What company do you work for (Optional)">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-xl-6">

                  <div class="" style="border-left: 2px solid #777;">
                    <div class="card-body pt-3">

                      <div class="row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About (Optional)</label>
                        <div class="col-md-8 col-lg-9">
                          <textarea id="about-textarea" name="about" class="form-control" id="about" style="height: 150px" placeholder="Brief info about your self"></textarea>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Your Job Title</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="job" type="text" class="form-control" id="Job" placeholder="Enter your Job title like manager, doctor" required>
                          <div class="invalid-feedback">Please provide your Job Title</div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                        <div class="col-md-8 col-lg-9">
                          <select name="gender" id="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>
                          <div class="invalid-feedback">Please select gender.</div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="dob" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                        <div class="col-md-8 col-lg-9">
                          <div class="row">
                            <div class="col">
                              <select name="dob_year" id="dob_year" class="form-control" required>
                                <option value="">Year</option>
                              </select>
                              <div class="invalid-feedback">Value required.</div>
                            </div>
                            <div class="col">
                              <select name="dob_month" id="dob_month" class="form-control" required>
                                <option value="">Month</option>
                              </select>
                              <div class="invalid-feedback">Value required.</div>
                            </div>
                            <div class="col">
                              <select name="dob_day" id="dob_day" class="form-control" required>
                                <option value="">Day</option>
                              </select>
                              <div class="invalid-feedback">Value required.</div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                        <div class="col-md-8 col-lg-9">
                          <select name="country" id="country" class="form-control" required>
                            <option value="">Select your country</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Åland Islands">Åland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Bouvet Island">Bouvet Island</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czechia">Czechia</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Territories">French Southern Territories</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernsey">Guernsey</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guinea-bissau">Guinea-bissau</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jersey">Jersey</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                            <option value="Korea, Republic of">Korea, Republic of</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macao">Macao</option>
                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montenegro">Montenegro</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau">Palau</option>
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn">Pitcairn</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russian Federation">Russian Federation</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Saint Helena">Saint Helena</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                            <option value="Samoa">Samoa</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Timor-leste">Timor-leste</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                            <option value="Western Sahara">Western Sahara</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                          </select>
                          <div class="invalid-feedback">Please enter your home coutry.</div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="nin" class="col-md-4 col-lg-3 col-form-label">NIN Number</label>
                        <div class="col-md-8 col-lg-9">
                          <input pattern="[A-Z0-9]{14}" min="14" name="nin" type="text" class="form-control" id="nin" placeholder="Enter your NIN number" required>
                          <div class="invalid-feedback">Please enter a valid NIN number with digits, letters, no spaces and 14 characters long.</div>
                          <small id="nin-status" class="text-success fw-bold"></small>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Home District" class="col-md-4 col-lg-3 col-form-label">Home District</label>
                        <div class="col-md-8 col-lg-9">
                          <input oninput="capitalizeFirstLetter(this)" name="district" type="text" class="form-control" id="Home District" placeholder="Enter your home district" required>
                          <div class="invalid-feedback">Please enter your home district.</div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="village" class="col-md-4 col-lg-3 col-form-label">Village</label>
                        <div class="col-md-8 col-lg-9">
                          <input oninput="capitalizeFirstLetter(this)" name="village" type="text" class="form-control" id="village" placeholder="Enter the village you come from" required>
                          <div class="invalid-feedback">Please enter the village you come from.</div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                        <div class="col-md-8 col-lg-9">
                          <input pattern="[+]?[0-9]+" name="phone" type="text" class="form-control" id="Phone" placeholder="Enter your phone number" required>
                          <div class="invalid-feedback">Please enter a valid phone number.</div>

                        </div>
                      </div>

                      <div class="text-left pt-3">
                        <button id="save-profile-button" type="submit" class="btn btn-primary btn-sm">Save Profile</button>
                        <a href="/{{$appName}}/auth/login/" class="btn btn-danger btn-sm">Cancel</a>
                      </div>


                    </div>
                  </div>

                </div>
              </div>
            </section>


          </div>

    </div>

    </section>
    </form><!-- End Profile Edit Form -->

    </div>
  </main><!-- End #main -->
  <script>
    function capitalizeFirstLetter(input) {
      input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }

    function capitalizeEveryWord(input) {
      var words = input.value.split(' ');

      for (var i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
      }

      input.value = words.join(' ');
    }
  </script>

  @include('partials/footer')

  <script>
    $(document).ready(function() {

      $('#nin').on('input', function() {
        let ninValue = $(this).val();

        $.ajax({
          method: 'post',
          url: '/{{$appName}}/auth/check-nin/',
          data: {
            nin: ninValue
          },
          success: function(response) {
            $('#nin-status').text(response.message);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#nin-status').text(jqXHR.responseJSON.message);
            if (jqXHR.responseJSON.status === 401) {
              $('#nin-status').text(jqXHR.responseJSON.message);
            }
          }
        })
      })

      $('#image').on('change', function() {
        let formData = new FormData();
        formData.append('image', this.files[0]);

        $('#progress-bar-container').show();

        $.ajax({
          method: 'post',
          url: '/{{$appName}}/image-upload/',
          data: formData,
          processData: false,
          contentType: false,
          xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total * 100;
                $('#progress-bar').val(percentComplete);
                $('#progress-percentage').text(Math.round(percentComplete) + '%');
              }
            }, false);
            return xhr;
          },
          success: function(response) {

            $('#image_url').val("{{$baseUrl}}/uploads/images/" + response);
            $('#profile-photo').attr('src', "{{$baseUrl}}/uploads/images/" + response);

          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('An Error occurred, failed to upload image')
          }
        })
      })

      $('#create-profile-form').submit(function(e) {
        e.preventDefault();

        if (this.checkValidity() === true) {

          $("#save-profile-button").attr('disabled', true);
          $("#save-profile-button").text('Please wait...');

          let formData = $(this).serialize();
          //cobine dob_year, dob_month and dob_day to dob and append to formData
          formData += "&dob=" + $('#dob_year').val() + "-" + $('#dob_month').val() + "-" + $('#dob_day').val();

          $.ajax({
            method: 'post',
            url: '/{{$appName}}/auth/save-profile/',
            data: formData,
            success: function(response) {
              $("#save-profile-button").attr('disabled', true);
              $("#save-profile-button").text('Profile created, redirecting...');

              setTimeout(function() {
                window.location.replace("/{{$appName}}/dashboard/organizations/choose/")
              }, 3000)
            },
            error: function(jqXHR, textStatus, errorThrown) {
              if (jqXHR.status === 401) {
                $("#save-profile-button").attr('disabled', false);
                $("#save-profile-button").text('Save Profile');

                Toastify({
                  text: jqXHR.responseJSON.message || "An Error Occured, Failled to save your profile data...",
                  duration: 4000,
                  gravity: 'top',
                  position: 'center',
                  backgroundColor: 'red',
                }).showToast();

              }
            }
          })
        }

      })


    })
  </script>

  <script>
    $(document).ready(function() {
      // Populate Year dropdown
      var startYear = new Date().getFullYear() - 20;
      var endYear = startYear - 60;
      for (var year = startYear; year >= endYear; year--) {
        $('#dob_year').append($('<option>', {
          value: year,
          text: year
        }));
      }

      // Populate Month dropdown
      var months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];
      for (var month = 1; month <= 12; month++) {
        $('#dob_month').append($('<option>', {
          value: month,
          text: months[month - 1]
        }));
      }

      // Populate Day dropdown based on selected Year and Month
      function populateDays() {
        var year = $('#dob_year').val();
        var month = $('#dob_month').val();
        var daysInMonth = new Date(year, month, 0).getDate();
        $('#dob_day').empty().append($('<option>', {
          value: '',
          text: 'Day'
        }));
        for (var day = 1; day <= daysInMonth; day++) {
          $('#dob_day').append($('<option>', {
            value: day,
            text: day
          }));
        }
      }

      $('#dob_year, #dob_month').change(populateDays);
    });
  </script>

  <script>
    $(document).ready(function() {
      const countrySelect = $('#country');

      countrySelect.change(function() {
        const country = $(this).val();
        const ninInput = $('#nin');
        const ninFeedback = ninInput.next('.invalid-feedback');

        // Adjust NIN input requirements based on the selected country
        switch (country) {
          case 'Uganda': // Uganda
            ninInput.attr('pattern', '[A-Z0-9]{14}');
            ninInput.attr('placeholder', 'Enter your NIN number');
            ninFeedback.text('Please enter a valid NIN number with digits, letters, no spaces and 14 characters long.');
            break;
          case 'Kenya': // Kenya
            ninInput.attr('pattern', '[0-9]{8}');
            ninInput.attr('placeholder', 'Enter your Kenyan ID number');
            ninFeedback.text('Please enter a valid Kenyan ID number with 8 digits.');
            break;
          case 'Tanzania': // Tanzania
            ninInput.attr('pattern', '[A-Z0-9]{20}');
            ninInput.attr('placeholder', 'Enter your Tanzanian NIN number');
            ninFeedback.text('Please enter a valid Tanzanian NIN number with digits, letters, no spaces and 20 characters long.');
            break;
            // Add more cases for other countries as needed
          default:
            ninInput.removeAttr('pattern');
            ninInput.attr('placeholder', 'Enter your NIN number');
            ninFeedback.text('Please enter a valid NIN number.');
            break;
        }
      });
    });
  </script>