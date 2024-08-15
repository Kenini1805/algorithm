func isValid(chars string) bool {
	stack := []rune{}

	mappingString := map[rune]rune{
		'}': '{',
		']': '[',
		')': '(',
	}
	for _, char := range chars {
		if open, exist := mappingString[char]; exist {
			if len(stack) == 0 || stack[len(stack)-1] != open {
				return false
			}

			stack = stack[:len(stack)-1]

		} else {
			stack = append(stack, char)
		}
	}

	return len(stack) == 0
}
