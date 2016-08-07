<li id="viewUserDetails">
    <a href="javascript:void(0)">   
        <i class="glyphicon glyphicon-list-alt"></i> &nbsp;View Details
    </a>
</li>
 
<input type="hidden" id="{{ $query->id }}_mStatus" name="maritalStatus" value="{{ $query->maritalStatus }}">
<input type="hidden" id="{{ $query->id }}_employment" name="employment" value="{{ $query->employment }}">
<input type="hidden" id="{{ $query->id }}_residenceAddress" name="residenceAddress" value="
    {{ $query->residenceStreet }}<br>{{ $query->residenceCity }}
    <br>{{ $query->residenceState }}  <br>   {{ $query->residenceZip }}  ">
<input type="hidden" id="{{ $query->id }}_officeAddress" name="officeAddress" value="
     {{ $query->officeStreet }}    <br>   {{ $query->officeCity }}  <br>   {{ $query->officeState }}  <br>{{ $query->officeZip }}  ">
<input type="hidden" id="{{ $query->id }}_photo" name="photo" value="{{ asset( '/images/'. $query->photo) }}    ">
<input type="hidden" id="{{ $query->id }}_name" name="name" value="{{ $query->firstName }} {{ $query->middleName }} {{ $query->lastName }}   ">
<input type="hidden" class="getEmployeeId" name="id" value="{{ $query->id }}">