</div>
<table style="width: 100%;"><tr><td>
<style>
html {
    height: 100%;
}
body{
    height: 100%;
    display: table;
}
.page-row {
  display: table-row;
  height: 1px;
}
.page-row-expanded { 
    height: 100%; 
}
.footer {
    bottom: 0px;
    width: 100%;
    overflow: hidden;
    margin: 0 auto;
    background: #<?php echo constant('FOOTER_BG'); ?>;
    min-height: 50px;
    padding: 5px;
    color: #<?php echo constant('FOOTER_TEXT'); ?>;
}
.footer-blocks {
	width: 100%;
	margin: 0 auto;
}
.footer-section {
    width: 32.6%; 
	margin: 2px auto;
    display: inline-block;
    padding: 5px;
    color: #<?php echo constant('FOOTER_TEXT'); ?>;
    vertical-align: middle;
}

@media (max-width: 520px) {
.footer-section {
    width: 100%; 
	margin: 2px auto;
    display: block;
    padding: 5px;
    vertical-align: top;
}
.footer-blocks {
	text-align: center;
}
}
</style>


<div class="footer">
	<div class="footer-blocks">
        <div class="footer-section">
            <?php 
                if (constant('FOOTER_CUSTOM_1_POSITION') == 'left') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_1'));
                }
                if (constant('FOOTER_CUSTOM_2_POSITION') == 'left') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_2'));
                }
                if (constant('FOOTER_CUSTOM_3_POSITION') == 'left') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_3'));
                }
                if (constant('COPYRIGHT_POSITION_BELOW') == 'no' && constant('COPYRIGHT_POSITION') == 'left') { 
                    echo constant('COPYRIGHT_MESSAGE');
                }
            ?>
        </div>
        <div class="footer-section">
            <?php 
                if (constant('FOOTER_CUSTOM_1_POSITION') == 'center') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_1'));
                }
                if (constant('FOOTER_CUSTOM_2_POSITION') == 'center') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_2'));
                }
                if (constant('FOOTER_CUSTOM_3_POSITION') == 'center') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_3'));
                }
                if (constant('COPYRIGHT_POSITION_BELOW') == 'no' && constant('COPYRIGHT_POSITION') == 'center') { 
                    echo constant('COPYRIGHT_MESSAGE');
                }
            ?>
        </div>
        <div class="footer-section">
            <?php 
                if (constant('FOOTER_CUSTOM_1_POSITION') == 'right') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_1'));
                }
                if (constant('FOOTER_CUSTOM_2_POSITION') == 'right') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_2'));
                }
                if (constant('FOOTER_CUSTOM_3_POSITION') == 'right') { 
                    echo htmlspecialchars_decode(constant('FOOTER_CUSTOM_3'));
                }
                if (constant('COPYRIGHT_POSITION_BELOW') == 'no' && constant('COPYRIGHT_POSITION') == 'right') { 
                    echo constant('COPYRIGHT_MESSAGE');
                }
            ?>
        </div>
    </div>
<?php 
if (constant('COPYRIGHT_POSITION_BELOW') == 'yes') { ?>
    <div style="width: 100%; padding: 5px; margin-left: -5px; text-align: <?php echo constant('COPYRIGHT_POSITION'); ?>;">
        <?php echo constant('COPYRIGHT_MESSAGE'); ?>
    </div>
<?php } ?>
</div>


<?php



?>
</td></tr></table>