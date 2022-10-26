<?php
/*
Plugin Name: Green Card Calculator
Plugin URI:
Description:Form to calculate when someone can expect to receive their Green Card
Author: Robert Granlund
Version:1.0
Author URI:https://rockintuit.com
*/
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

define('GCCURL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );

define('GCCPATH', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );



function ajaxcalculator_enqueuescripts() {
wp_enqueue_style( 'calculator-css', GCCURL.'/css/calculator.css');
wp_enqueue_script('ajax_custom_script', GCCURL.'/js/ajaxCalculator.js', array('jquery'), '0.1.0', true );
wp_localize_script( 'ajax_custom_script', 'greencardajax', array('ajaxurl' => admin_url('admin-ajax.php'),
'nonce' => wp_create_nonce('ajax-nonce')));
}

add_action('wp_enqueue_scripts', 'ajaxcalculator_enqueuescripts');




function calculator_admin_style() {
    wp_enqueue_style('calculator-admin-styles', GCCURL.'/css/calculator-admin.css');
  }
  add_action('admin_enqueue_scripts', 'calculator_admin_style');





  

 
add_action('admin_menu', 'calculator_admin_page');
 
function calculator_admin_page(){
    add_menu_page( 'Green Card Calculator', 'Green Card Calculator', 'manage_options', 'green-card-calculator', 'calculator_init' );
}
 
function calculator_init(){ ?>
<h1>Green Card Calculator Data Fields</h1>

<form id="green-calculator" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <div class="col">
        <div class="calc-form-control">
            <h3>All Other Countries</h3>
        </div>
        <div class="calc-form-control">
            <h3>China Mainland</h3>
        </div>
        <div class="calc-form-control">
            <h3>India</h3>
        </div>
        <div class="calc-form-control">
            <h3>Mexico</h3>
        </div>
        <div class="calc-form-control">
            <h3>Philippines</h3>
        </div>
    </div>
    <?php
global $wpdb;
$table_name = 'glq_greencard_calculator';
$results = $wpdb->get_results("SELECT * FROM $table_name");
$count = $wpdb->get_var( "SELECT count(*) FROM  $table_name");

foreach($results as $row)
{
$id = $row->id;
$fs = $row->family_sponsored;
$all = $row->all_areas;
$china = $row->china_mainland;
$india = $row->india;
$mexico = $row->mexico;
$phil = $row->philippines;
?>
    <div class="col">
        <div class="calc-form-control">
            <input type="hidden" name="calc_id[]" id="calc_id" class="" value="<?php echo $id; ?>" />
            <input type="text" name="all[]" id="all" class="" value="<?php echo $all; ?>" />
        </div>
        <div class="calc-form-control">
            <input type="text" name="china[]" id="china" class="" value="<?php echo $china; ?>" />
        </div>
        <div class="calc-form-control">
            <input type="text" name="india[]" id="india" class="" value="<?php echo $india; ?>" />
        </div>
        <div class="calc-form-control">
            <input type="text" name="mexico[]" id="mexico" class="" value="<?php echo $mexico; ?>" />
        </div>
        <div class="calc-form-control">
            <input type="text" name="phil[]" id="phil" class="" value="<?php echo $phil; ?>" />
        </div>
    </div>
    <?php } ?>
    <div class="col">
        <!--  START Submit  -->
        <div id="calc-submit" class="calc-form-control-submit" style="display: block;">
            <input type='submit' name="calculator" value='Save Data' class="calculate-btn" style="cursor: pointer">
        </div>
        <!--  END Submit  -->
    </div>
</form>



<?php 
if (isset($_POST['calculator'])) {

    for ( $i=0;$i<$count;$i++) {
        $insert_values =array(
            'all_areas' => $_POST['all'][$i],
            'china_mainland' => $_POST['china'][$i],
        'india' => $_POST['india'][$i],
        'mexico' => $_POST['mexico'][$i],
        'philippines' => $_POST['phil'][$i],
            );
            $where=array('id' => $_POST['calc_id'][$i] );
            $wpdb->update( $table_name, $insert_values, $where);
    }


    header("location: " . $_SERVER['REQUEST_URI']);
    }





}  //  End Function





function ajaxcalculator_show_form()

{

?>




<form id="ajaxcalculatorform" enctype="multipart/form-data">

    <div id="ajaxcontact-text">

        <!--  START A  -->
        <div id="a" class="calc-form-control">

            <strong>Have you filed Form I-130?</strong> <br />

            <label for="i-130">Yes <input type="radio" id="i-130-yes" name="i-130" class="i-130" value="Yes" /></label>
            <label for="i-130">No <input type="radio" id="i-130-no" name="i-130" class="i-130" value="No" /></label>
        </div>
        <!--  END A  -->

        <!--  START B  -->
        <div id="b" class="calc-form-control" style="display: none;">
            <label>
                <strong>What is the priority date?</strong> <br />
                <input type="date" id="citizen_date" name="citizen_date" />
            </label>
        </div>
        <!--  END B  -->

        <!--  START C  -->
        <div id="c" class="calc-form-control" style="display: none;">
            <label>
                <strong>What is the intending immigrant's category?</strong> <br />
                <select id="citizen_cat" name="citizen_cat">
                    <option value="">please select</option>

                    <option value="IR1">IR1 - Spouse of U.S. citizen</option>
                    <option value="IR2">IIR2 - Unmarried
                        child (under 21 years of age) of a U.S. citizen</option>
                    <option value="IR3">IR3 - Orphan adopted abroad by a
                        U.S.
                        citizen</option>
                    <option value="IR4">IR4 - Orphan
                        to be adopted in the United States by a U.S. citizen</option>
                    <option value="IR5">IR5 - Parent of a
                        U.S.
                        citizen (who is at least 21 years old)</option>

                    <option value="F1">F1 - Unmarried, adult sons and daughters (age 21 or over) of U.S. citizens
                    </option>
                    <option value="F2A">F2A - Spouses and unmarried children (under age 21) of permanent residents
                    </option>
                    <option value="F2B">F2B - Unmarried adult sons and daughters of permanent residents</option>
                    <option value="F3">F3 - Married sons and daughters (any age) of U.S. citizens</option>
                    <option value="F4">F4 - Brothers and sisters of U.S. citizens</option>
                    <option value="IDK">I do not know</option>
                </select>

            </label>
        </div>
        <!--  END C   -->


        <!--  START D  -->
        <div id="d" class="calc-form-control" style="display: none;">
            <label>
                <strong>Are you the petitioner or the intending immigrant?</strong> <br />
                <label for="petitioner">Petitioner <input type="radio" id="petitioner" class="petitioner"
                        name="petitioner" value="Petitioner" /></label>
                <label for="immigrant">Intending Immigrant <input type="radio" id="immigrant" class="petitioner"
                        name="petitioner" value="Intending Immegrant" /></label>
                <br />
            </label>
        </div>
        <!--  END D  -->


        <!--  START P1  -->
        <div id="p1" class="calc-form-control" style="display: none;">
            <label>
                <strong>What is your status?</strong> <br />

                <label for="citizen">Citizen <input class="perm-res" type="radio" id="citizen" name="citizen"
                        value="Citizen" /></label>
                <label for="permanent-resident">Permanent Resident <input class="perm-res" type="radio" id="resident"
                        name="citizen" value="Permanent Resident" /></label>

                <br />
            </label>
        </div>
        <!--  END P1 -->

        <!--  START P2  -->
        <div id="p2" class="calc-form-control" style="display: none;">
            <label>
                <strong>How is the intending immigrant related to you?</strong> <br />
                <select id="intend_relation" name="intend_relation">
                    <option value="">please select</option>
                    <option value="IR1">Spouse</option>
                    <option value="IR5">Parent</option>
                    <option value="IR2">Child (under age 21)</option>
                    <option value="F1">Son or daughter (age 21 and over)</option>
                    <option value="F4">Sibling</option>
                    <option value="NE">Fianc&#233;</option>
                </select>
            </label>
        </div>
        <!--  END P2 -->

        <!--  START P3  -->
        <div id="p3" class="calc-form-control" style="display: none;">
            <label>
                <strong>Where are you or the intending immigrant currently a citizen or national?</strong> <br />
                <select id="img_from" name="img_from">
                    <option value="">please select</option>
                    <option value="China">China</option>
                    <option value="India">India</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Another Country">Another Country</option>
                </select>
            </label>
        </div>
        <!--  END P3 -->


        <!--  START i1  -->
        <div id="i1" class="calc-form-control" style="display: none;">
            <label>
                <strong>What is the petitioner's status?</strong> <br />

                <label for="citizen">U.S. Citizen <input class="citizen-pet" type="radio" id="citizen-pet"
                        name="citizen_pet" value="Petitioner" /></label>
                <label for="resident">Permanent Resident <input class="citizen-pet" type="radio" id="resident-pet"
                        name="citizen_pet" value="Permanent Resident" /></label>

                <br />
            </label>
        </div>
        <!--  END i1  -->

        <!--  START i2  -->
        <div id="i2" class="calc-form-control" style="display: none;">
            <label>
                <strong>How are you related to the petitioner?</strong> <br />
                <select id="relationpet" name="relationpet">
                    <option value="">please select</option>
                    <option value="IR1">Spouse</option>
                    <option value="IR5">Parent</option>
                    <option value="IR2">Child (under age 21)</option>
                    <option value="F1">Son or daughter (age 21 and over)</option>
                    <option value="F4">Sibling</option>
                    <option value="NE">Fianc&#233;</option>
                </select>
            </label>
        </div>
        <!--  END i2 -->

        <!--  START I3  
        <div id="i3" class="calc-form-control" style="display: none;">
            <label>
                <strong>Where are you currently a citizen or national?</strong> <br />
                <select id="ajaxcalculatorfromalt" name="ajaxcalculatorfromalt">
                    <option>please select</option>
                    <option value="China">China</option>
                    <option value="India">India</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Another Country">Another Country</option>
                </select>
            </label>
        </div>
         END i3 -->


        <!--  START Submit  -->
        <div id="calc-submit" class="calc-form-control-submit" style="display: block;">
            <button id="calculate-btn" type="submit" class="btn btn-primary calculate-btn"
                style="cursor: pointer;">CalculateDate</button>
        </div>
        <!--  END Submit  -->
        <div id="ajaxcalculator-response"></div>
    </div>

</form>
<!--  Loading Animation  -->
<div class="loading-modal">
    <!-- Place at bottom of page -->
</div>
<?php
}





add_action( 'wp_ajax_form_action', 'form_action' );
add_action( 'wp_ajax_nopriv_form_action', 'form_action' );
//Saving Ajax Data
//add_action('wp_ajax_save_post_details_form','form_action');

/*  This function to be used when we start saving information
***  There needs to be a custom post type for this information to be saved under
function save_enquiry_form_action() {
    $citizen_date = $_POST['post_details']['citizen_date'];
    $citizen_cat = $_POST['post_details']['citizen_cat'];
    $relation = $_POST['post_details']['relation'];
    $from = $_POST['post_details']['from'];
    $relation_to_pet = $_POST['post_details']['relation_to_pet'];
    $citizen = $_POST['post_details']['citizen'];

	$args = [
        'citizen_date' => $citizen_date,
        'citizen_cat' => $citizen_cat,
        'relation' => $relation,
        'from' => $from,
        'relation_to_pet' => $relation_to_pet,
        'citizen' => $citizen,
		'post_status'=> 'publish',
		'post_type'=>'post',
		'post_date'=> get_the_date()
	];
 
	$is_post_inserted = wp_insert_post($args);
 
	if($is_post_inserted) {
		return "success";
	} else {
		return "failed";
	}
}
***/


function form_action() {
    $newsletter_content = get_field('newsletter_content', 28178);
    $disclaimer = get_field('disclaimer', 28178);
    
    $citizen_date = $_POST['post_details']['citizen_date'];
    $citizen_cat = $_POST['post_details']['citizen_cat'];
    $citizen_pet = $_POST['post_details']['citizen_pet'];
    $relation = $_POST['post_details']['relation'];
    $from = $_POST['post_details']['from'];
    $relation_to_pet = $_POST['post_details']['relation_to_pet'];
    $citizen = $_POST['post_details']['perm_res'];
    $intend_relation = $_POST['post_details']['intend_relation'];

    $ir1 = "IR1 - Spouse of U.S. citizen ";
    $ir2 = "IR2 - Unmarried child (under 21 years of age) of a U.S. citizen";
    $ir3 = "IR3 - Orphan adopted abroad by a U.S. citizen";
    $ir4 = "IR4 - Orphan to be adopted in the United States by a U.S. citizen";
    $ir5 = "IR5 - Parent of a U.S. citizen (who is at least 21 years old)";
    $f1 = "F1 - Unmarried, adult sons and daughters (age 21 or over) of U.S. citizens";
$f2a = "F2A - Spouses and unmarried children (under age 21) of permanent residents";
$f2b = "F2B - Unmarried adult sons and daughters of permanent residents";
$f3 = "F3 - Married sons and daughters (any age) of U.S. citizens";
$f4 = "F4 - Brothers and sisters of U.S. citizens";
$idk = "I don't know";
$ne = "Fianc&#233;";


//  Statement to set where the person if from for the query
if($citizen_cat != "") {
    $ccat = $citizen_cat;
} elseif($intend_relation != "") {
    $ccat = $intend_relation;
} else {
    $ccat = $relation_to_pet;
}

 $today = date("Y-m-d");

 global $wpdb;

$table_name = 'glq_greencard_calculator';
$results = $wpdb->get_results("SELECT * FROM $table_name WHERE family_sponsored = '".$ccat."'");

foreach($results as $row)
{
$id = $row->id;
$fs = $row->family_sponsored;
$all = $row->all_areas;
$china = $row->china_mainland;
$india = $row->india;
$mexico = $row->mexico;
$phil = $row->philippines;
}


switch ($from) {
    case "Another Country":
        $place = $all;
        break;
    case "China":
        $place = $china;
        break;
    case "India":
        $place = $india;
        break;
    case "Mexico":
        $place = $mexico;
        break;
    case "Philippines":
        $place = $phil;
        break;
  default:
$place = $all;
}

if( !empty($citizen_cat)) {
switch ($citizen_cat) {
    case "IR1":
        $cat = $ir1;
        $current = 'C';
        break;
    case "IR2":
        $cat = $ir2;
        $current = 'C';
        break;
    case "IR3":
        $cat = $ir3;
        $current = 'C';
        break;
    case "IR4":
        $cat = $ir4;
        $current = 'C';
        break;
    case "IR5":
        $cat = $ir5;
        $current = 'C';
        break;
    case "F1":
        $cat = $f1;
        $current = 'No';
        break;
    case "F2A":
        $cat = $f2a;
        $current = 'No';
        break;
    case "F2B":
      $cat = $f2b;
      $current = 'No';
      break;
    case "F3":
          $cat = $f3;
          $current = 'No';
          break;
    case "F4":
        $cat = $f4;
        $current = 'No';
        break;
    case "IDK":
        $cat = $idk;
        $current = 'No';
            break;
    default:
  $cat = $f1;
  $current = 'No';
  }
}
if( !empty($intend_relation)) {
    switch ($intend_relation) {
        case "NE":
            $cat = $ne;
            $current = 'No';
            break;
        case "IR1":
            $cat = $ir1;
            $current = 'C';
            break;
        case "IR2":
            $cat = $ir2;
            $current = 'C';
            break;
        case "IR5":
            $cat = $ir5;
            $current = 'No';
            break;
        case "F1":
            $cat = $f1;
            $current = 'No';
            break;
        case "F4":
            $cat = $f4;
            $current = 'No';
            break;
        default:
      $cat = $ir1;
      $current = 'C';
      }
    } else {
        $intend_relation = "";
    }
    if( !empty($relation_to_pet)) {
        switch ($relation_to_pet) {
            case "NE":
                $cat = $ne;
                $current = 'No';
                break;
            case "IR1":
                $cat = $ir1;
                $current = 'C';
                break;
            case "IR2":
                $cat = $ir2;
                $current = 'C';
                break;
            case "IR5":
                $cat = $ir5;
                $current = 'No';
                break;
            case "F1":
                $cat = $f1;
                $current = 'No';
                break;
            case "F4":
                $cat = $f4;
                $current = 'No';
                break;
            default:
          $cat = $ir1;
          $current = 'C';
          }
        } else {
            $relation_to_pet = "";
        }
?>


<div class="return-cont">
    <div class="results-cont">
        <div class="results-cat">
            <h4 class="calc-title">Category</h4>
            Based on your selection, we are evaluating the category: <b><?php echo $cat; ?></b>.
            <!--
            <?php   echo '<br />$citizen_cat: '.$citizen_cat.'<br />';
                    echo '$relation_to_pet: ' .$relation_to_pet.'<br />';
                    echo ' $intend_relation: '. $intend_relation.'<br />';
            ?>
-->
        </div>
    </div>
    <div class="title">
        <h2 class="calc-title">Estimated Wait Time</h2>
    </div>

    <?php

 if($citizen_date != "") {
$date = $citizen_date;
 } else {
    $date = $today;
 }

// Creates DateTime objects
  $datetime1 = date_create($place);
  $datetime2 = date_create($date);
 
// Calculates the difference between DateTime objects
  $interval = date_diff($datetime1, $datetime2);
  $interval_year = $interval->format('%y');
  $interval_month = $interval->format('%m');
  $due_date = $interval->format('%y years and %m months');
  $estimate_date = date('F Y', strtotime($today. ' + '.$interval_year.' years + '.$interval_month.' months')); 

  if ($current != "C") {
    //echo '<h7>PART 1 </h7><br />';

if($intend_relation != "" || $relation_to_pet != "") {
    //echo '<h7>PART 2</h7> <br />';
    if ( 
    ($citizen == "Permanent Resident" &&  $intend_relation != "IR1") || 
    ($citizen == "Permanent Resident" &&  $intend_relation != "IR2") ||
    ($citizen_pet == "Permanent Resident" &&   $relation_to_pet != "IR1") || 
    ($citizen_pet  == "Permanent Resident" &&   $relation_to_pet != "IR2")) 
    
    {
        //echo '<h7>PART 3</h7> <br />';
    echo '<div class="description">
        Sorry, this is not a qualifying relationship. US immigration law only allows a US citizen to petition this type
        of relationship.
    </div>';
  //  IF Fiance Message
          } elseif($intend_relation == "NE" || $relation_to_pet == "NE") {
                echo '<div class="description"><h4>SPECIAL Fianc&#233; MESSAGE</h4></div>';
          } else { ?>
    <h3><?php echo $interval->format('%y years and %m months'); ?></h3><br />
    <div class="description">
        Currently, USCIS is working on petitions with <?php echo $place; ?> priority date. That means it will take
        approximately <?php echo $due_date; ?> to reach your case. Based on this estimate, a green card will be
        available to the beneficiary in approximately <?php echo $estimate_date; ?>.
    </div>
    <?php } 
   
} else { 
                //echo '<h7>PART 6 </h7><br />';
 
                //  If the Location IS NOT C = Current
if($place !="C") {
?>
    <h3><?php echo $interval->format('%y years and %m months'); ?></h3><br />
    <div class="description">
        Currently, USCIS is working on petitions with <?php echo $place; ?> priority date. That means it will take
        approximately <?php echo $due_date; ?> to reach your case. Based on this estimate, a green card will be
        available to the beneficiary in approximately <?php echo $estimate_date; ?>.
    </div>
    <?php } else 
    //  If the Location is Current
        {
        echo 'Based on this estimate, your petition is likely to become current soon. When the date nears, the National Visa Center will be contacting the petitioner and beneficiary to obtain information for the next steps in the process.';
        
    } ?>

    <?php } ?>
    <?php } else {
        echo 'Based on this estimate, your petition is likely to become current soon. When the date nears, the National Visa Center will be contacting the petitioner and beneficiary to obtain information for the next steps in the process.';
        
    } 
    ?>


    <div class="newsletter-signup">
        <h2 class="calc-title">Sign Up for Free Updates</h2>
        <?php echo do_shortcode('[optin-monster-shortcode id="tavd1gp5dt5ux3pmbhmp"]'); ?>
    </div>
    <div class="newsletter-content">
        <?php echo $newsletter_content; ?>
    </div>
    <div class="disclaimer">
        <?php echo $disclaimer; ?>
    </div>
</div> <!--  END Return Container  -->
<?php wp_die();
}