<?php

function shouldBeCommutative(){
    return sum(2,3) === sum(3,2);
}



function shouldBeAssociative(){

    if(sum(10, sum(2,3)) !== 15)
    {
        return false;
    }
    return sum(10, sum(2,3)) === sum (3, sum(2,10));
}