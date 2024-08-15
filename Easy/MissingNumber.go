func missingNumber(nums []int) int {
	sort.Ints(nums)
	var result int
	for i, v := range nums {
		if i != v {
			result = i

			return result
		}
	}
	if result == 0 {
		result = len(nums)

	}

	return result
}

//https://leetcode.com/problems/missing-number/?envType=problem-list-v2&envId=oq45f3x3