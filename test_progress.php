<?php
function calculateProgress($initial_weight, $latest_weight, $goal_weight) {
    $progress = 0;

    if ($goal_weight > $initial_weight) {
        // Weight Gain Scenario
        $progress = (($latest_weight - $initial_weight) / ($goal_weight - $initial_weight)) * 100;
    } else {
        // Weight Loss Scenario
        $progress = (($initial_weight - $latest_weight) / ($initial_weight - $goal_weight)) * 100;
    }

    // Ensure progress is within the range of 0% to 100%
    return max(0, min(100, $progress));
}

// Test Cases
$test_cases = [
    ['initial_weight' => 70, 'latest_weight' => 75, 'goal_weight' => 80], // Weight Gain (progress expected)
    ['initial_weight' => 80, 'latest_weight' => 75, 'goal_weight' => 70], // Weight Loss (progress expected)
    ['initial_weight' => 60, 'latest_weight' => 60, 'goal_weight' => 80], // No Change, Gain Scenario
    ['initial_weight' => 90, 'latest_weight' => 85, 'goal_weight' => 70], // In Progress Weight Loss
    ['initial_weight' => 50, 'latest_weight' => 80, 'goal_weight' => 80], // Goal Achieved (Weight Gain)
    ['initial_weight' => 100, 'latest_weight' => 70, 'goal_weight' => 70], // Goal Achieved (Weight Loss)
    ['initial_weight' => 85, 'latest_weight' => 90, 'goal_weight' => 75], // Moving Away From Goal (Weight Loss)
];

foreach ($test_cases as $test) {
    $progress = calculateProgress($test['initial_weight'], $test['latest_weight'], $test['goal_weight']);
    echo "Initial: {$test['initial_weight']} kg, Latest: {$test['latest_weight']} kg, Goal: {$test['goal_weight']} kg → Progress: {$progress}%\n";
}
?>
