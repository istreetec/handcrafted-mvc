<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Router;
use PHPUnit\Framework\TestCase;
use App\Exceptions\RouteNotFoundException;

class RouterTest extends TestCase
{
    // setUp(), everything which needs re-using lives here.
    // called before each method is ran
    protected function setUp(): void
    {
        parent::setUp();

        // e.g. Re-use router object in all tests
        $this->router = new Router();
    }


    // NB:: The actual tests are written inform of methods within the test class.

    // Hint:: Open Your Already Written class side by side and test
    // each method i.e. Unit

    // e.g. it_registers_a_route() to test register()

    /** @test */
    public function it_registers_a_route(): void
    {
        // - Given we have a router object

        // - When we call a register method i.e. with args if present
        $this->router->register("get", "/users", ["Users", "index"]);

        // build up/mimic expected value manually
        $expected = [
            "get" => [
                "/users" => ["Users", "index"]
            ]
        ];

        // - Then we assert route was registered
        $this->assertSame($expected, $this->router->routes());
    }


    /** @test */
    public function it_registers_a_get_route(): void
    {
        // Follow same GWT pattern
        $this->router->get("/users", ["Users", "index"]);
        $expected = [
            "get" => [
                "/users" => ["Users", "index"]
            ]
        ];
        $this->assertSame($expected, $this->router->routes());
    }
    /** @test */
    public function it_registers_a_post_route(): void
    {
        $this->router->post("/users", ["Users", "store"]);
        $expected = [
            "post" => [
                "/users" => ["Users", "store"]
            ]
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    /** @test */
    public function there_are_not_routes_when_router_is_created(): void
    {
        $router = new Router();
        $this->assertEmpty($router->routes());
    }



    // NOW TESTING RESOLVE method Parts i.e. resolve()

    /** 
     * @test 
     * @dataProvider \Tests\DataProviders\RouterDataProvider::routeNotFoundCases
     */
    public function it_throws_route_not_found_exception(
        // NB:: A test case can accept arguments from a data provider
        string $requestUri, string $requestMethod
    ): void {
        // Simulate a class using Anonymous classes
        $users = new class () {
            public function delete(): bool
            {
                return true;
            }
        };


        // Given registered route(s).
        $this->router->post("/users", [$users::class, "store"]);
        $this->router->get("/users", ["Users", "index"]);

        // NB:: exception has to be asserted before the code which throws it
        // it's ran. Otherwise the code will throw the exception and the 
        // assertion will never be reached.

        // Tip:: Follows GWT pattern but implicitly. Since assertion is the "Then"
        $this->expectException(RouteNotFoundException::class);

        // When an attempt is made to resolve them
        $this->router->resolve($requestUri, $requestMethod);
    }


    /** @test */
    public function it_resolves_value_from_a_closure(): void
    {
        // Given a route which uses a callback i.e. a closure
        $this->router->get("/users", fn() => [1, 2, 3]);

        // When expected returned value is [1, 2, 3]
        $expected = [1, 2, 3];

        // Then resolves to [1, 2, 3]
        $this->assertSame($expected, $this->router->resolve("/users", "get"));
    }

    /** @test */
    public function it_resolves_route(): void
    {
        $users = new class () {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        // Given a route
        $this->router->get("/users", [$users::class, "index"]);

        $this->assertSame([1, 2, 3], $this->router->resolve("/users", "get"));
    }
}



// P.S
// Best practices;;
// - Prefer descriptive names even if they are long
// - Follow; Given - When - Then pattern.
// - Or Follow; Arrange - Act - Assert pattern.
// - Write what it's you are testing in words or sentences

// Tip:: 
// When unit testing a method, we only test that method not the journey i.e. 
// it's relationship with other methods.
// e.g. register() we don't have to care whether the route resolves or not
// thus the arguments don't matter.

// NB:: 
// Alaways have one unit test per method. Don't combine testing multiple
// methods inside a single unit test.


// Best Practice::
// - Don't over-use data provider
// - Useful for things like Validations where you want to provide a valid data
// and assert that everything passes.

// Or want to provide invalid data and assert that everything fails by availing
// different cases.



/*******************************************************************************
 *
 *
 *    FROM HERE GO TO https://laracasts.com for more breadth knowledge on PHP 
 *    testing
 *
 *
 ********************************************************************************/
