<?php
class LongestCommonPrefix {

    /**
     * @param array $strs
     * @return String
     */
    public static function longestCommonPrefix($strs) {
            $result = $strs[0];
            for ($j=1; $j < count($strs); $j++) {
                while (strpos($strs[$j], $result) !== 0) {
                    $result = (substr($result, 0, -1));

                    if (strlen($result) == 0) {
                        return "";
                    }
                }
            }
            return ($result);
    }
}

LongestCommonPrefix::longestCommonPrefix(["flower", "flow" ,"flight"]);