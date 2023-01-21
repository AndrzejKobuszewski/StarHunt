<?php
$pages = get_posts(array('post_type' => 'page', 'numberposts' => -1));
$pagesTitles = array('Main page');
for ($x = 0; $x < sizeof($pages); $x++) {
    array_push($pagesTitles, get_the_title($pages[$x]));
}
;
$postsHTML = get_posts(array('post_type' => 'NPharmaPlatfInteg', 'numberposts' => -1));
$markersHTML = array();
for ($x = 0; $x <= sizeof($postsHTML); $x++) {
    array_push($markersHTML, get_the_title($postsHTML[$x]));
}
;

?>

<form action='strona wtyczki'>
    <fieldset style="border: 3px solid black; margin-top: 1.2rem; margin-right: 1.2rem;">
        <legend style="font-size: 1.2rem; margin: 0rem 2rem;">Availability of the <b>HTMLs</b> on particular Websites:
        </legend>
        <br>
        <div style="margin-top:2%; display: flex; flex-wrap: wrap; justify-content: space-around;">
            <form></form>

            <?php for ($x = 0; $x < (sizeof($markersHTML) - 1); $x++) {
                echo '<form  style="" action="strona wtyczki" >
        <fieldset style="border: 1px solid black;  margin: 2%; padding: 6%;  ">
        <br>
        <legend> <b>' . $markersHTML[$x] . '</b> </legend>
        <label for="HTML Custom Tag"><b>' . $markersHTML[$x] . '</b> is available at page(s):</label><br>
        ';

                for ($y = 0; $y < (sizeof($pagesTitles)); $y++) {
                    echo '<input type="checkbox"pageTiltle" name="pageTiltle" >
                    <label for="pageTiltle">' . $pagesTitles[$y] . ' </label><br> ';
                }
                echo '<br>
            <input type="checkbox" id="deactivate" name="deactivate" >
            <label for="deactivate"> deactivate this Tag</label><br>    
            <br>
        <input type="submit" value="Submit">
        </fieldset>
    </form>
      '
                ;

            } ?>

        </div>
        <br><br>
        <div style="margin: 2%; display: flex; justify-content: space-around; width: 100%; ">
            <div style="margin: 2%;">
                <input type="button" value="tick all pages">
                <input type="button" value="untick all pages">
            </div>
            <div style="margin: 2%;">
                <input type="submit" value="S U B M I T   A L L"
                    style="border-radius: 50% 20% / 10% 40%; font-weight: bold; background-color: green; color: silver; height: 2rem;">
            </div>
        </div>
    </fieldset>
</form>
<!-- 
<br><br>

<form  action='strona wtyczki'>
<fieldset style="border: 3px solid black; margin-top: 1.2rem; margin-right: 1.2rem;">
<legend style="font-size: 1.2rem; margin: 0rem 2rem;">Executable <b>scripts placed in HTMLs Tags</b></legend>
 <br>
 <div style="margin-top:2%; display: flex; flex-wrap: wrap; justify-content: space-around;">
   <form></form>

   <?php for ($x = 0; $x < (sizeof($markersHTML) - 1); $x++) {
       echo '
   <form  style="" action="strona wtyczki">
   <fieldset style="border: 1px solid black;  margin: 2%; padding: 6%;  ">
   <br>
   <legend><b>' . $markersHTML[$x] . '</b> </legend>
   <label for="HTML Custom Tag">In marker <b>' . $markersHTML[$x] . '</b>  is executed following javascript code:</label><br>
   <br>
   <div> <b> &lt' . $markersHTML[$x] . '>' . '</b>&lt' . 'script></div>
       <textarea id="scriptInTag" name="scriptInTag" rows="3" cols="42">
       coding
       </textarea>
   <div> &lt' . '/script>' . '<b>&lt/' . $markersHTML[$x] . '></b></div>
   <input type="submit" value="Submit">
   </fieldset>
</form>';

   }
   ; ?>
</fieldset>
</form>  -->

<script>
    // grips
    let allPages = document.querySelector();
    let allDeactivate = document.querySelector();

</script>