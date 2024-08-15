func climbStairs(n int) int {
	if n <= 1 {
		return 1
	}

	prev1 := 1
	prev2 := 1

	for i := 2; i <= n; i++ {
		current := prev1 + prev2
		prev2 = prev1
		prev1 = current
	}
	return prev1
}