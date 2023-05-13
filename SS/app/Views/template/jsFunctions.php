<script type="text/javascript">
  function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'block')
      e.style.display = 'none';
    else
      e.style.display = 'block';
  }

  function changeFunc() {
    document.getElementById('bday_box').style.display = 'block';
    var selectBox = document.getElementById("guest_id_type");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    if (selectedValue == "state_dmv") {
      var e = document.getElementById('state_box');
      if (e.style.display == 'block')
        e.style.display = 'none';
      else {
        e.style.display = 'block'
        document.getElementById('other_box').style.display = 'none';
        var states = getElementById('state');
        states.required = true;
      }
    } else if (selectedValue == "hoot_loot") {
      document.getElementById('state_box').style.display = 'none';
      document.getElementById('other_box').style.display = 'none';
      document.getElementById('bday_box').style.display = 'none';

    } else if (selectedValue == "military") {
      document.getElementById('state_box').style.display = 'none';
      document.getElementById('other_box').style.display = 'none';
      document.getElementById('bday_box').style.display = 'block';

    } else if (selectedValue == "passport") {
      document.getElementById('state_box').style.display = 'none';
      document.getElementById('other_box').style.display = 'none';
      document.getElementById('bday_box').style.display = 'block';
    } else if (selectedValue == "other") {
      document.getElementById('bday_box').style.display = 'block';
      /*Hide the states dropdown */
      var e = document.getElementById('state_box');
      e.style.display = 'none';
      /* hide/show the 'others' box */
      var e = document.getElementById('other_box');
      if (e.style.display == 'block')
        e.style.display = 'none';
      else {
        e.style.display = 'block';
        var other = document.getElementById('other_type_of_id');
        other.required = true;
      } //end of else
    }
  }
</script>