<?php

/**
* Strings and Regex
*/
class Gluttony
{
	public function strings_are_not_objects()
	{
		$story = "Dante woke up and it was raining";
		assert_that(isset($story))->is_equal_to(true);
		assert_that(is_object($story))->is_equal_to(false);
		assert_that(is_string($story))->is_equal_to(true);
	}

	public function strings_are_scalar()
	{
		$story = "the air smelled terrible";
		assert_that(is_scalar($story))->is_equal_to(true);
	}
	
	public function string_can_be_concatenated_with_the_dot_operator()
	{
		$string = "A " . "giant" . " three-headed " . "dog was growling " . "at him";
		assert_that($string)->is_equal_to("A giant three-headed dog was growling at him");
	}

	public function strings_can_be_quite_large()
	{
		$the_third_circle = "Cerberus eats the mud, making him a glutton too.";
		assert_that(strlen($the_third_circle))->is_equal_to(48);
	}

	public function strings_can_contain_many_things()
	{
		$ciacco = "his name was Giacomo";

		assert_that(strpos($ciacco, ' '))->is_equal_to(3);
		assert_that(strpos($ciacco, 'Giacomo'))->is_equal_to(13);
		
		// We have a helper function to check for strings inside of other
		// strings, safely implemented with strpos().
		
		assert_that($ciacco)->contains_string('name');
	}

	public function sometimes_they_are_hard_to_find()
	{
		$ciacco = "his name was Giacomo";

		assert_that(strpos($ciacco, 'his'))->is_equal_to(0);
		assert_that(strpos($ciacco, 'hog'))->is_equal_to(false);
		
		assert_that(strpos($ciacco, 'his'))->is_identical_to(0);
		assert_that(strpos($ciacco, 'hog'))->is_identical_to(false);

		/* Virgil says: This is why strpos and several other functions
		should always be used with strict equality (=== instead of ==) */
	}

	public function you_can_build_them_up__()
	{
		assert_that(implode(['a', 'b', 'c']))->is_equal_to('abc');

		$words = implode(' and ', ['hog', 'pig', 'glutton']);
		assert_that($words)->is_equal_to('hog and pig and glutton');

		// a quirk of implode
		assert_that(implode(['hog', 'pig', 'glutton'], ' and ') == $words)->is_equal_to(true);
	}

	public function __and_tear_them_down__()
	{
		$words = 'hog and pig and glutton';
		assert_that(explode(' and ', $words))->is_equal_to(['hog', 'pig', 'glutton']);
	}

	public function __and_build_them_up_again()
	{
		$words = str_repeat('rain ', 4);
		assert_that($words)->is_equal_to('rain rain rain rain ');
	}

	public function regular_expressions_can_help_you_find_patterns()
	{
		$a_followed_by_anything = '/a.*/';
		
		assert_that(preg_match($a_followed_by_anything, 'a'))->is_identical_to(1);
		assert_that(preg_match($a_followed_by_anything, 'ab'))->is_identical_to(1);
		assert_that(preg_match($a_followed_by_anything, 'all souls in the third circle'))->is_identical_to(1);

		// The pattern can match anywhere in the string.
		assert_that(preg_match($a_followed_by_anything, 'live in filthy rain, on vile grounds'))->is_identical_to(1);
	}

	public function you_need_a_way_to_look_for_specific_patterns()
	{
		$a_followed_by_anything_at_the_start = '/^a.*/';
		assert_that(preg_match($a_followed_by_anything_at_the_start, 'all souls in the third circle'))->is_identical_to(1);
		assert_that(preg_match($a_followed_by_anything_at_the_start, 'live in filthy rain, on vile grounds'))->is_identical_to(0);
	}

	public function preg_match_will_give_you_what_it_found_if_you_ask_nicely()
	{
		$matches = [];
		preg_match('/a.*/', 'but only if you can answer', $matches);
		assert_that($matches)->is_equal_to(['an answer']);
	}

	public function regex_will_consume_as_much_as_it_can()
	{
		$an_a_followed_by_any_letters_and_then_b = '/a.*b/';
		$matches = [];

		preg_match($an_a_followed_by_any_letters_and_then_b, 'abra kadabra', $matches);

		assert_that($matches)->is_equal_to(['abra kadab']);
	}

	public function you_can_ask_for_specific_matching_parts_with_parentheses()
	{
		$story = "Dante is very interested in the story of Florence in Canto VI";

		// Virgil: the + means 'at least one', the brackets say 'any letter a-to-z or A-to-Z'
		$pattern = '/the story of ([a-zA-Z]+)/'; 

		$matches = [];
		preg_match($pattern, $story, $matches);

		assert_that($matches[0])->is_equal_to('the story of Florence');
		assert_that($matches[1])->is_equal_to('Florence');
	}

	/**
	* @suppress_warnings
	*/
	public function preg_match_carries_the_same_danger_as_strpos()
	{

		$good_pattern = '/^I am Dante$/'; // a $ specifies that no more characters are in the string.
		$bad_pattern = '/missing the last forward slash';

		// is_equal_to() -> == operator
		assert_that(preg_match($good_pattern, 'anyone have an umbrella?'))->is_equal_to(0);
		assert_that(preg_match($bad_pattern, 'anyone have an umbrella?'))->is_equal_to(false);

		// is_identical_to() -> === operator
		assert_that(preg_match($good_pattern, 'anyone have an umbrella?'))->is_identical_to(0);
		assert_that(preg_match($bad_pattern, 'anyone have an umbrella?'))->is_identical_to(false);
	}

	public function preg_match_will_only_return_a_single_match()
	{
		$pattern = '/a ([a-z]at)/';
		$matches = [];

		preg_match($pattern, 'he brought a cat, a rat and a bat', $matches);

		// Virgil: preg_match pick the first matching pattern as its answer
		assert_that($matches)->is_identical_to(['a cat', 'cat']);
	}

	public function preg_match_all_will_return_every_match()
	{
		$pattern = '/a ([a-z]at)/';
		$matches = [];

		preg_match_all($pattern, 'he brought a cat, a rat and a bat', $matches);

		assert_that($matches[0])->is_identical_to(['a cat', 'a rat', 'a bat']);
		assert_that($matches[1])->is_identical_to(['cat', 'rat', 'bat']);
	}
	
	/**
	* Exercise III. What did you eat?
	* Cerberus is a good doggie. Yes you are! Yes you are!
	* What do you have in your mouths? Tell me exactly!
	*/
	private function whats_in_the_mouths_of_cerberus($mouth_contents)
	{
	    if(!$mouth_contents || $mouth_contents === 'nothing') {
	        return [];
        }
        $matches = preg_split('/, | and /', $mouth_contents);
		return $matches ? array_unique($matches) : [];
	}
	
	// make these pass:
	public function when_cerberus_is_just_eating_mud()
	{
		assert_that($this->whats_in_the_mouths_of_cerberus('mud'))
			->is_equal_to(['mud']);
	}
	
	public function when_cerberus_is_eating_mud_and_some_bones()
	{
		assert_that($this->whats_in_the_mouths_of_cerberus('mud, bones'))
			->is_equal_to(['mud', 'bones']);
	}
	
	public function why_do_you_have_a_honey_cake_boy()
	{
		assert_that($this->whats_in_the_mouths_of_cerberus('mud, bones and honey cake'))
			->is_equal_to(['mud', 'bones', 'honey cake']);
		
		assert_that($this->whats_in_the_mouths_of_cerberus('mud and honey cake, bones and honey cake'))
			->is_equal_to(['mud', 'honey cake', 'bones']);
	}
	
	public function oh_hes_asleep_now()
	{
		assert_that($this->whats_in_the_mouths_of_cerberus('nothing'))
			->is_equal_to([]);
	}
	
	public function really_really_really_asleep()
	{
		assert_that($this->whats_in_the_mouths_of_cerberus(null))
			->is_equal_to([]);
	}
}