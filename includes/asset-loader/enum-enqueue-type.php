<?php
/**
 * Describes the allowable Enqueue types
 *
 * @package KJR_Dev
 */

namespace KJR_Dev;

/** Allowable Enqueue Types */
enum Enqueue_Type {
	case script;
	case style;
	case both;
}
