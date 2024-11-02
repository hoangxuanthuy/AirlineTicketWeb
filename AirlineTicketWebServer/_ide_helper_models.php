<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account query()
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Flight> $flights
 * @property-read int|null $flights_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aircraft whereUpdatedAt($value)
 */
	class Aircraft extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Flight> $incomingFlights
 * @property-read int|null $incoming_flights_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Flight> $outgoingFlights
 * @property-read int|null $outgoing_flights_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Airport whereUpdatedAt($value)
 */
	class Airport extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Aircraft|null $aircraft
 * @property-read \App\Models\Airport|null $departureAirport
 * @property-read \App\Models\Airport|null $destinationAirport
 * @property-read \App\Models\FlightGate|null $flightGate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Aircraft|null $aircraft
 * @property-read \App\Models\Airport|null $departureAirport
 * @property-read \App\Models\Airport|null $destinationAirport
 * @property-read \App\Models\FlightGate|null $gate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereUpdatedAt($value)
 */
	class Flight extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Airport|null $airport
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Flight> $flights
 * @property-read int|null $flights_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightGate whereUpdatedAt($value)
 */
	class FlightGate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Flight|null $flight
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlightSeat whereUpdatedAt($value)
 */
	class FlightSeat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Luggage whereUpdatedAt($value)
 */
	class Luggage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Passenger whereUpdatedAt($value)
 */
	class Passenger extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedAt($value)
 */
	class Promotion extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeatClass whereUpdatedAt($value)
 */
	class SeatClass extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Flight|null $flight
 * @property-read \App\Models\Luggage|null $luggage
 * @property-read \App\Models\Promotion|null $promotion
 * @property-read \App\Models\SeatClass|null $seatClass
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket query()
 */
	class Ticket extends \Eloquent {}
}

