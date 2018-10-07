<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<h1>HELLO WORLD</h1>';
?>
<style>
    body {
        text-align: center; 
    }
    #main {
        text-align: center; 
    }
    .heart {
	font-size: 250px;
	color: #e00;
	animation: beat .35s infinite alternate;
	transform-origin: center;
}

/* Heart beat animation */
@keyframes beat{
	to { transform: scale(1.4); }
}
   </style>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <div class="unsub-title">
This is what you do to me...
            </div>
        <?php endwhile; ?>
   
<div class="heart">&#x2665;</div>
       
    </main><!-- #main -->
</div><!-- #primary -->

