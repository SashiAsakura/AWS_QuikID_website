Filter:
<table>
<form action="http://www.fusionpipe.com/_users_track" method="get">

<tr><td>Company</td><td><input type="text" name="fil_company" value="@company@"></td></tr>
<tr><td>Email</td><td><input type="text" name="fil_email" value="@email@"></td></tr>
<tr><td>Agree to keep in touch</td><td><select name="fil_product">@products@</select></tr>
<tr><td>start date:</td><td><input type="text" name="fil_stdate" value="@stdate@" placeholder="eg. November 20, 2014"></td></tr>
<tr><td>end date:</td><td><input type="text" name="fil_enddate" value="@enddate@"  placeholder="eg. November 20, 2014"></td></tr>
<tr><td>Show all records:</td><td><input type="checkbox" name="fil_all" @all@></td></tr>
<tr><td><input type="submit" name="search" value="search"></td><td>&nbsp</td></tr>
</form>
</table>