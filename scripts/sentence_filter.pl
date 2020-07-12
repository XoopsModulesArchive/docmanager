#!/usr/bin/perl


# Some variable for text quality
$max_word_lenght = 20;
$min_word_for_sentence = 6;



$word_lenght = 0;
$word_number = 0;
$is_max_word_lenght = 0;
$sentence = '';


# Loop all the STDIN data
while ( read(STDIN, $buffer, 1) ) {
    
    # Check if the char is a number or characters
    if ( $buffer =~ /\w/ ) {
        $word_lenght++;
    
        $sentence = $sentence.$buffer;
    }
    # Check if it's a space
    elsif ( $buffer =~ / / ) {
    
        # Check if the word is too long
        if ( $word_lenght >= $max_word_lenght ) {
            $is_max_word_lenght = 1;
        }
    
        $word_lenght = 0;
    
        $word_number++;
        $sentence = $sentence.$buffer;
    }
    # Check if the char is an end of sentence
    elsif ( $buffer =~ /\.|\!|\?/ ) {
    
    
        # Check if we have an exception
        if ( $buffer =~ /\./ && check_exception($buffer, $old_buffer) ) {
            $word_lenght++;
            $sentence = $sentence.$buffer;
        }
        # If not, we have the end of sentence
        else {
            if ( $word_lenght >= $max_word_lenght ) {
                $is_max_word_lenght = 1;
            }
            
            # If the sentence is right
            if ( $is_max_word_lenght == 0 && $word_number >= $min_word_for_sentence) {
            
                # And don't have tab or newline
                if ( $sentence !~ /\n|\t/ ) {
                    print $sentence.$buffer." ";
                }
            }
    
        
            # Reset everything
            $sentence = '';
            $word_lenght = 0;
            $word_number = 0;
            $is_max_word_lenght = 0;
        }
    }
    elsif ( $buffer !~ /\n|\t|\s/ ) {
        $word_lenght++;
    
        $sentence = $sentence.$buffer;    
    }

    # Keep the old buffer
    $old_buffer = $buffer;
}



# Sub to check if we have an exception for the dot
sub check_exception {
    my($arg0,$arg1);
    $arg0 = $_[0];
    $arg1 = $_[1];


    # Check if the previous buffer was a capital letter (like in abreviation like C.R.I.S.P.)
    if ( $old_buffer =~ /[A-Z]/) { 
        $return_value = 1;
    }
    else {
        $return_value = 0;
    }

    return $return_value;
}
