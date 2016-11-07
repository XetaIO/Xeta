<?= $this->element('meta', [
    'title' => __('Website in maintenance')
]) ?>

<?php $this->start('scriptBottom');
    echo $this->Html->script([
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js',
        'snap.svg-min'
    ]);?>

    <script type="text/javascript">
        var errorCode = "";
    </script>

    <?= $this->Html->script([
        'brokebot.min'
    ]);?>

<?php $this->end() ?>

<?= $this->Html->css([
    'errors.min'
], ['block' => true])?>

<div class="robotpage-top-half">
    <div id="robot_holder">
        <svg id="brokebotSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 551 239" enable-background="new 0 0 551 239" xml:space="preserve" preserveAspectRatio="xMidYMax">
            <text id="errorCodeTxt" transform="matrix(1 0 0 1 6.7231 240.0011)" class="error_code"></text>
            <g id="robotHead">
                <rect x="359.2" y="173.1" class="robot_limbs_and_ears" width="6.4" height="23.3"/>
                <rect x="348.1" y="185.4" class="robot_body" width="28.5" height="11"/>
                <path class="robot_limbs_and_ears" d="M392,197.7h-59.2l0,0c0-3.7,3-6.8,6.8-6.8h45.6C388.9,190.9,392,193.9,392,197.7L392,197.7z"/>
                <rect x="288.5" y="207.5" class="robot_limbs_and_ears" width="147.7" height="18.7"/>
                <path class="robot_body" d="M419.3,238.9H305.5c-5.5,0-10-4.5-10-10V207c0-5.5,4.5-10,10-10h113.8c5.5,0,10,4.5,10,10v21.9
                    C429.3,234.4,424.8,238.9,419.3,238.9z"/>
                <circle class="robot_eye_whites" cx="317" cy="216.4" r="11.7"/>
                <circle class="robot_eye_whites" cx="407.7" cy="216.4" r="11.7"/>
                <g id="eyesMove">
                    <g id="eyesBlink">
                        <rect x="311" y="210.4" class="robot_eyes" width="12.1" height="12.1"/>
                        <polygon class="robot_eyes_highlight" points="323.1,210.4 311,210.4 323.1,222.5"/>
                        <rect x="401.7" y="210.4" class="robot_eyes" width="12.1" height="12.1"/>
                        <polygon class="robot_eyes_highlight" points="413.7,210.4 401.7,210.4 413.7,222.5"/>
                    </g>
                </g>
                <rect x="339" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <rect x="347.3" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <rect x="355.6" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <rect x="363.9" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <rect x="372.2" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <rect x="380.5" y="219.9" class="robot_limbs_and_ears" width="5.3" height="9.8"/>
                <circle class="robot_antenna" id="robotAntenna" cx="362.4" cy="167.9" r="10"/>
                <circle class="robot_antenna_highlight" id="robotAntennaHighlight" cx="362.4" cy="167.9" r="5.5"/>
            </g>
            <g id="robotbody">
                <rect x="154.3" y="184.1" class="robot_limbs_and_ears" width="7" height="16.7"/>
                <path class="robot_limbs_and_ears" d="M162.6,234.1h-9.7c-2.8,0-5-2.2-5-5v-22.7c0-2.8,2.2-5,5-5h9.7c2.8,0,5,2.2,5,5v22.7
                    C167.6,231.8,165.3,234.1,162.6,234.1z"/>
                <path class="robot_hands_feet" d="M172.7,238.9c0-8.2-6.7-14.9-14.9-14.9c-8.2,0-14.9,6.7-14.9,14.9H172.7z"/>
                <circle class="robot_joints_and_belly" cx="157.8" cy="203.1" r="5.1"/>
                <path class="robot_limbs_and_ears" d="M221.3,234.1h-9.7c-2.8,0-5-2.2-5-5v-22.7c0-2.8,2.2-5,5-5h9.7c2.8,0,5,2.2,5,5v22.7
                    C226.3,231.8,224,234.1,221.3,234.1z"/>
                <path class="robot_hands_feet" d="M231.3,238.9c0-8.2-6.7-14.9-14.9-14.9c-8.2,0-14.9,6.7-14.9,14.9H231.3z"/>
                <circle id="leftKnee" class="robot_joints_and_belly" cx="216.4" cy="203.1" r="5.1"/>

                <g id="upperBody">

                    <rect x="146" y="143" transform="matrix(-0.968 -0.2511 0.2511 -0.968 362.8447 338.4026)" class="robot_limbs_and_ears" width="114" height="6.1"/>
                    <g id="leftArm">
                        <path id="leftOuterClaw" class="robot_hands_feet" d="M247.7,212.6l21.1,21.1c5.8-5.8,5.8-15.3,0-21.1C262.9,206.7,253.5,206.7,247.7,212.6
                            z"/>
                        <path id="leftInnerClaw" class="robot_hands_feet" d="M247.7,212.6c-5.8,5.8-5.8,15.3,0,21.1l21.1-21.1
                            C262.9,206.7,253.5,206.7,247.7,212.6z"/>
                        <rect x="254.7" y="161.1" class="robot_limbs_and_ears" width="7" height="25"/>
                        <path class="robot_limbs_and_ears" d="M263,217.5l-9.7,0c-2.8,0-5-2.3-5-5l0-22.7c0-2.8,2.3-5,5-5l9.7,0c2.7,0,5,2.3,5,5l0,22.7
                            C268,215.3,265.7,217.5,263,217.5z"/>
                        <circle class="robot_joints_and_belly" cx="258.2" cy="186.5" r="5.1"/>
                    </g>
                    <path class="robot_body" d="M270.4,163.5c1.7-6.7-2.3-13.6-9-15.4c-6.7-1.7-13.6,2.3-15.4,9c-1.7,6.7,2.3,13.6,9,15.4
                        C261.8,174.3,268.7,170.3,270.4,163.5z"/>

                        <rect x="130" y="138.3" transform="matrix(0.8845 0.4666 -0.4666 0.8845 83.8309 -45.3494)" class="robot_limbs_and_ears" width="7" height="16.7"/>
                    <g id="rightLowerArm">
                        <path id="rightInnerClaw" class="robot_hands_feet" d="M119,181.3l21.1,21.1c5.8-5.8,5.8-15.3,0-21.1C134.2,175.5,124.8,175.5,119,181.3z"
                            />
                        <path id="rightOuterClaw" class="robot_hands_feet" d="M119,181.3c-5.8,5.8-5.8,15.3,0,21.1l21.1-21.1C134.2,175.5,124.8,175.5,119,181.3z"
                            />
                        <path class="robot_limbs_and_ears" d="M134.5,186.2l-9.7,0.1c-2.7,0-5-2.2-5-5l-0.2-22.7c0-2.7,2.2-5,5-5l9.7-0.1c2.7,0,5,2.2,5,5l0.2,22.7
                            C139.5,183.9,137.3,186.2,134.5,186.2z"/>
                    </g>
                    <circle class="robot_joints_and_belly" cx="129.4" cy="154.3" r="5.1"/>
                    <path class="robot_body" d="M154.3,133.4c1.7-6.7-2.3-13.6-9-15.4c-6.7-1.7-13.6,2.3-15.4,9c-1.7,6.7,2.3,13.6,9,15.4
                        C145.7,144.2,152.6,140.2,154.3,133.4z"/>
                    <path class="robot_hands_feet" d="M210.2,119.6l-1.4-1.5c0.1-0.1,9.1-8.7,7.2-15.5l1.9-0.5C220.2,110,210.6,119.2,210.2,119.6z"/>
                    <path class="robot_hands_feet" d="M215.9,117.4l-1.3-1.5c0.4-0.3,9.3-7.5,17.2-7.7l0,2C224.6,110.3,216,117.3,215.9,117.4z"/>
                    <path class="robot_body" d="M210,116l-0.7-1.9c0.1,0,11.8-4.5,12.6-11.5l2,0.3C222.9,111.1,210.5,115.8,210,116z"/>

                    <rect x="203.8" y="108.1" transform="matrix(0.7809 0.6246 -0.6246 0.7809 121.0947 -105.8214)" class="robot_limbs_and_ears" width="15.2" height="23.2"/>
                    <path class="robot_body" d="M217.3,207.9l-62.6-16.2c-5.3-1.4-8.5-6.9-7.2-12.2l19.6-58.3c1.4-5.3,6.4-8.7,11.2-7.4l56.2,14.6
                        c4.8,1.2,7.6,6.6,6.2,11.9l-11.2,60.5C228.1,206,222.6,209.3,217.3,207.9z"/>
                    <path class="robot_joints_and_belly" d="M211.5,184.8l-40.4-10.5c-3.4-0.9-5.5-4.4-4.6-7.9l12.7-37.6c0.9-3.4,4.1-5.6,7.2-4.8l36.3,9.4
                        c3.1,0.8,4.9,4.3,4,7.7l-7.2,39.1C218.5,183.6,214.9,185.6,211.5,184.8z"/>
                </g>
            </g>
        </svg>
    </div>
</div>

<div class="robotpage-bottom-half">
    <div>
        <p id="robot-text">
            <?= __("Oops ! The website is in maintenance, our monkey's team are working on it !") ?>
        </p>
    </div>
</div>
