func longestConsecutive(nums []int) int {
	sort.Ints(nums)
	if len(nums) <= 0 {
		return 0
	}
	result := 1
	longest := 1
	for i := 1; i < len(nums); i++ {
		if nums[i] == (nums[i-1]) {
			continue
		}
		if nums[i] == (nums[i-1] + 1) {
			result++
		} else {
			if result > longest {
				longest = result
			}
			result = 1
		}
	}
	if result > longest {
		longest = result
	}
	return longest
}