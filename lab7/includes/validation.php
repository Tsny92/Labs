<?php

function validatePreferredTime($preferredTime)
{
    $allowedTimes = ['Morning', 'Afternoon', 'Evening'];
    if (!in_array($preferredTime, $allowedTimes, true)) {
        return 'Choose a valid preferred time.';
    }
    return '';
}

function validateTopics($topics)
{
    $allowedTopics = ["Exam review", "Practice problems", "Study plan"];

    if ($topics === []) {
        return "Select at least one valid topic.";
    }

    foreach ($topics as $topic) {
        if (!in_array($topic, $allowedTopics, true)) {
            return "Select at least one valid topic.";
        }
    }

    return "";
}

function validateReason($reason)
{
    $length = function_exists("mb_strlen") ? mb_strlen(trim($reason)) : preg_match_all("/./us", trim($reason));

    if ($length < 10 || $length > 500) {
        return "Describe your request using 10 to 500 characters.";
    }

    return "";
}
