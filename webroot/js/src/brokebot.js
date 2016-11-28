//Claw vars.
var clawTweenTime = 1;//how long it takes to open the claws after they snap shut
var rightClawRepeatDelay = 1;//time between claw snaps
var leftClawRepeatDelay = 1.7;//time between claw snaps

//Body vars.
var bodySwayTime = 1;//how long it takes to sway left or right
var bodySwayAmount = 5;//how much it sways (in degrees)

//Eye vars.
var blinkRepeatTime = 2;//time between each blink
var eyesMoveRepeatTime = 0.9; //how often the eyes move


window.addEventListener('load', function () {
    iniBrokebot();
}, false);

function iniBrokebot()
{
    animateBrokebot();
}

//run each of the animations
function animateBrokebot()
{

    var f = Snap('#brokebotSVG');

    var rightInnerClaw = f.select('#rightInnerClaw');
    var rightOuterClaw = f.select('#rightOuterClaw');
    var leftInnerClaw = f.select('#leftInnerClaw');
    var leftOuterClaw = f.select('#leftOuterClaw');
    var upperBody = f.select('#upperBody');
    var eyesMove = f.select('#eyesMove');
    var eyesBlink = f.select('#eyesBlink');
    var leftArm = f.select('#leftArm');
    var rightLowerArm = f.select('#rightLowerArm');
    var robotHead = f.select('#robotHead');
    var errorCodeTxt = f.select('#errorCodeTxt');
    var robotAntenna = f.select('#robotAntenna');
    var robotAntennaHighlight = f.select('#robotAntennaHighlight');

    errorCodeTxt.node.textContent = errorCode.toString();

    //Animate claws.
    setTimeout(function () {
        TweenMax.from(rightInnerClaw.node, clawTweenTime, {
            rotation : 45,
            transformOrigin : "11px 15px",
            repeat : -1,
            repeatDelay : rightClawRepeatDelay
        });

        TweenMax.from(rightOuterClaw.node, clawTweenTime, {
            rotation : -45,
            transformOrigin : "15px 15px",
            repeat : -1,
            repeatDelay : rightClawRepeatDelay
        });
    }, rightClawRepeatDelay*1000);

    setTimeout(function () {
        TweenMax.from(leftInnerClaw.node, clawTweenTime, {
            rotation : -45,
            transformOrigin : "15px 15px",
            repeat : -1,
            repeatDelay : leftClawRepeatDelay
        });

        TweenMax.from(leftOuterClaw.node, clawTweenTime, {
            rotation : 45,
            transformOrigin : "11px 15px",
            repeat : -1,
            repeatDelay : leftClawRepeatDelay
        });
    }, leftClawRepeatDelay*1000);

    //Animate robot antenna.
    TweenMax.to(robotAntenna.node, 0.5, {
        fill : "#F2748D",
        yoyo : true,
        repeat : -1,
    });
    TweenMax.to(robotAntennaHighlight.node, 0.5, {
        fill : "#e12b52",
        yoyo : true,
        repeat : -1,
    });
    //animate the error code in
    TweenMax.from(errorCodeTxt.node, 2, {opacity:0});




    //Animate swaying body and arms.
    TweenMax.to(upperBody.node, bodySwayTime, {
        rotationZ : -bodySwayAmount,
        transformOrigin : "50px 92px",
        yoyo : true,
        repeat : -1,
        ease : Quad.easeInOut
    });
    TweenMax.to(leftArm.node, bodySwayTime, {
        delay : 0.3,
        rotationZ : bodySwayAmount,
        transformOrigin : "15px -11px",
        yoyo : true,
        repeat : -1,
        ease : Quad.easeInOut
    });
    TweenMax.to(rightLowerArm.node, bodySwayTime, {
        delay : 0.5,
        rotationZ : bodySwayAmount,
        transformOrigin : "15px 0px",
        yoyo : true,
        repeat : -1,
        ease : Quad.easeInOut
    });

    //Animate blinking and eye movement.
    TweenMax.to(eyesMove.node, 0.05, {
        delay : eyesMoveRepeatTime,
        x : -2,
        y : -2,
        repeatDelay : eyesMoveRepeatTime,
        repeat : -1,
        yoyo : true
    });

    TweenMax.from(eyesBlink.node, 0.3, {
        scaleY : 0.2,
        repeatDelay : blinkRepeatTime,
        repeat : -1,
        transformOrigin : "0px 6px"
    });

}
