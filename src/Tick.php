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
    protected static $options = [
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
    ];

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
        if (self::$options['disable_output']) {
            self::$options['counter']++;
            return;
        }
        if (null === $symbol) {
            $symbol = self::$options['symbol'];
        }
        if (self::$options['counter'] % self::$options['width_divider'] == 0) {
            echo self::$options['eol'];
            if (self::$options['print_numbers']) {
                echo str_pad(
                    intval(self::$options['counter'] / self::$options['width_divider']),
                    self::$options['num_padding'],
                    '0',
                    STR_PAD_LEFT
                ) . ': ';
            }
        }
        self::$options['counter']++;
        if (self::$options['counter'] % self::$options['divider'] == 0) {
            echo $symbol;
        }
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
    public static function setOptions(array $options)
    {
        self::$options                  = array_merge(self::$options, $options);
        self::$options['width_divider'] = self::$options['width'] * self::$options['divider'];
    }

    /**
     * Set progress tick individual option
     *
     * @param $option   - Option name
     * @param $value    - Option value to set
     *
     * @return bool $success
     */
    public static function setOption($option, $value)
    {
        $options  = array_keys(self::$options);
        $disabled = array('width_divider');

        if (!in_array($option, $options) || in_array($option, $disabled)) {
            return false;
        }

        self::$options[$option] = $value;
        if ($option = 'width' || $option = 'divider') {
            self::$options['width_divider'] = self::$options['width'] * self::$options['divider'];
        }

        return true;
    }

    /**
     * Reset current tick counter to 0
     */
    public static function resetCounter()
    {
        self::$options['counter'] = 0;
    }

    /**
     * Return the current ticks counter
     *
     * @return int $count
     */
    public static function getCounter()
    {
        return self::$options['counter'];
    }

    /**
     * An alias for a tick($symbol) method
     *
     * @param null|string $symbol
     */
    public static function printTick($symbol = null)
    {
        return self::tick($symbol);
    }

    /**
     * An alias for setOptions method
     *
     * @param array $options
     */
    public static function setTickOptions(array $options)
    {
        return self::setOptions($options);
    }

    /**
     * An alias for setOption method
     *
     * @param string $option
     * @param mixed  $value
     *
     * @return bool
     */
    public static function setTickOption($option, $value)
    {
        return self::setOption($option, $value);
    }

    /**
     * An alias for getCounter method
     *
     * @return int $counter
     */
    public static function getTickCounter()
    {
        return self::getCounter();
    }

    /**
     * An alias for resetCounter method
     */
    public static function resetTickCounter()
    {
        return self::resetCounter();
    }
}
