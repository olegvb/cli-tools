<?php
namespace Olegvb\CliTools;

/**
 * Class Tick -- Command line (CLI) tools helper to print progress ticks.
 *
 * Created: 2015-12-01 by Oleg Baranovsky <oleg@baranovsky.org>
 */
class Tick
{
    /**
     * @var array -- options for progress ticks
     */
    protected static $_tickOptions = array(
        'divider'        => 1,          // Tick divider (number of tick cycles to print one tick)
        'width'          => 100,        // Row width (number of tick to print in one row)
        'symbol'         => '.',        // Default symbol to print if not specified explicitly
        'eol'            => PHP_EOL,    // End of line character to print at the end of each line
        'counter'        => 0,          // Initial counter value
        'print_numbers'  => true,       // Print counter numbers at the beginning of each string
        'num_padding'    => 4,          // Number of zero padding for the counter numbers
        'disable_output' => false,      // If this option is enabled, no output will be produced, only count the ticks.

        // calculated fields
        'width_divider'  => 100,        // A multiple of width and divider, pre-calculated for extra performance
    );

    /**
     * Print a progress tick.
     *
     * This function is designed to server as a progress indicator for the long lasting processes when
     * running from the command line interface (CLI).
     *
     * It will print a tick symbol for each 'divider' cycles. When line reaches the line width, it will print the
     * 'eol' character and (optionally) the counter number at the beginning of the new line.
     *
     * @param null|string $symbol -- symbol to print or use default 'symbol' parameter if omitted
     */
    public static function tick($symbol = null)
    {
        if (self::$_tickOptions['disable_output']) {
            self::$_tickOptions['counter']++;
            return;
        }
        if (null === $symbol) $symbol = self::$_tickOptions['symbol'];
        if (self::$_tickOptions['counter'] % self::$_tickOptions['width_divider'] == 0) {
            echo self::$_tickOptions['eol'];
            if (self::$_tickOptions['print_numbers']) {
                echo str_pad(
                        intval(self::$_tickOptions['counter'] / self::$_tickOptions['width_divider']),
                        self::$_tickOptions['num_padding'], '0', STR_PAD_LEFT
                    ) . ': ';
            }
        }
        self::$_tickOptions['counter']++;
        if (self::$_tickOptions['counter'] % self::$_tickOptions['divider'] == 0) {
            echo $symbol;
        }
    }

    /**
     * An alias for a tick($symbol) function.
     *
     * @param null|string $symbol
     */
    public static function printTick($symbol = null)
    {
        return self::tick($symbol);
    }

    /**
     * Set progress tick options in bulk
     *
     * Available options:
     *   - divider  -- divider for ticks, only print a tick every 'divider' times
     *   - width    -- bar width for the tick marks. Prints 'eol' after width is reached
     *   - symbol   -- default tick symbol to print
     *   - eol      -- end of line 'eol' to print
     *   - counter  -- initial counter
     *
     * @param array $options
     */
    public static function setTickOptions(array $options)
    {
        self::$_tickOptions = array_merge(self::$_tickOptions, $options);
        self::$_tickOptions['width_divider'] = self::$_tickOptions['width'] * self::$_tickOptions['divider'];
    }

    /**
     * Set progress tick individual option
     *
     * @param $option   - Option name
     * @param $value    - Option value to set
     *
     * @return bool $success
     */
    public static function setTickOption($option, $value)
    {
        $options  = array_keys(self::$_tickOptions);
        $disabled = array('width_divider');

        if (!in_array($option, $options) || in_array($option, $disabled)) return false;

        self::$_tickOptions[$option] = $value;
        if ($option = 'width' || $option = 'divider') {
            self::$_tickOptions['width_divider'] = self::$_tickOptions['width'] * self::$_tickOptions['divider'];
        }

        return true;
    }

    /**
     * Reset current tick counter to 0
     */
    public static function resetTickCounter()
    {
        self::$_tickOptions['counter'] = 0;
    }

    /**
     * Return the current ticks counter
     *
     * @return int $count
     */
    public static function getTickCounter()
    {
        return self::$_tickOptions['counter'];
    }

}
