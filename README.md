# Architektura

- DDD (Domain Driven Design)
- Hexagonalna
- Cqrs (Command Query Responsibility Segregation)

## DDD

Ta architektura każe nam dzielić projekt na Domeny np. **Board, User**.
Każda Domena jest dzielona na warstwy:
- Aplikacji
- Domeny
- Infrastruktury

Jedynymi wyjątkowymi Domenami są **Shared, User**.
W Shared trzymamy różnego rodzaju interfejsy oraz globalne klasy do użytku w każdej Domenie.
W User trzymamy wszystko co jest związane z Użytkownikiem, w głównej mierze zachowuje się jak każda
inna Domena, ale jako jedyna pozwala na robienie z nią relacji w repozytorium między Domenami.

### Warstwa Aplikacji

#### Główne zasady:
1. W tej warstwie skupiamy się na implementacji aplikacji i integracji
z zewnętrznymi komponentami np. **Baza danych**.
2. Obsługujemy tutaj komunikację API
3. Trzymamy tutaj query, commandy i handlery dla CQRS i przeprowadzamy operacje na obiektach domenowych
4. Trzymamy tutaj DTO dla requestów przychodzących i wychodzących z API
5. Mamy dostęp tylko do warstwy **Domenowej**.

### Warstwa Domenowa

#### Główne zasady:
1. W tej warstwie skupiamy sie tworzeniu Agregatów oraz VO (ValueObject) (Podobna zasada jak w Entity)
2. Tworzymy Porty (Interfejsy) dla warstwy **Infrastruktury**
3. Tworzymy metody do operacji na bazie danych (w Agregatach i VO)
4. Trzymamy tutaj eventy Domenowe (np. po stworzeniu obiektu w bazie jest wysyłany event który można przechwycić w innej lub tej samej Domenie)
5. Mamy dostęp tylko do warstwy **Infrastruktury**

#### Agregaty

Agregaty to zbiór metod, entity oraz VO dotyczących danego obiektu z bazy danych.
Przeprowadzamy tam operacje pobierania danych, aktualizacji lub tworzeniu całych obiektów.
Agreagty wyróżniają się tym że mają identyfikator.
Nazewnictwo metod różni się od tego z Doctrine Entity, bo są bardziej precyzyjne i określają dokładnie co robią,
rezygnujemy z prefixów Get, Set (Wyjątkiem jest User bo używamy paczek JWT które wykorzystują interfejsy z funkcjami GET).
W każdej Domenie znajduje się maksymalnie **JEDEN** Agregat Root.
Każdy Agregat który jest w relacji z głównym nie może być Rootem.
Aby dostać się do Agregata który jest w relacji z Rootem, musimy najpierw pobrać roota
i po jego danych przejść przez jego relacje. Ważną zasadą **DDD** jest zakaz pobierania 
bezpośrednio Agregata który jest zagnieżdżony w relacji z rootem

przykład RootAgregat: Board/Domain/Entity/Board
przykład Agregata w relacji z Rootem: Board/Domain/Entity/Column

Zalety:
 - Wysoka spójność danych: Agregaty pozwalają na gromadzenie powiązanych obiektów w jednym miejscu, co ułatwia zarządzanie spójnością danych.
 - Izolacja logiczna: Agregaty mogą zawierać reguły biznesowe oraz logiczne operacje, co prowadzi do izolacji i uproszczenia zarządzania kodem.
 - Wyższy poziom abstrakcji: Dzięki agregatom można łatwiej reprezentować złożone struktury danych, co prowadzi do bardziej zrozumiałego i utrzymanego kodu.

Wady:
 - Złożoność: Agregaty mogą wprowadzać dodatkową złożoność do projektu, zwłaszcza gdy struktura danych jest skomplikowana.
 - Potencjalna nadmierna rozbudowa: Nadmiernie skomplikowane agregaty mogą prowadzić do nadmiernego zawiłego kodu i trudności w utrzymaniu.
 - Możliwe trudności z testowaniem: Złożone agregaty mogą być trudniejsze do testowania, co może wpłynąć na jakość testów jednostkowych.

#### VO (Value Object)

VO jest to prosty obiekt, który reprezentuje zmierzoną, wyliczoną lub opisaną wartość.
Są to zazwyczaj bardzo małe obiekty takie jak zakres dat, pieniądz
czy inne proste wartości jak np. Id, Jakiś string, Email.
Jednak co ważne, w odróżnieniu od Agregatów, nie posiadają identyfikatora.
W VO możemy przypisać odpowiednie Metody dla tych wartości, przez co jak będziemy chcieli wykorzystać
ten sam VO w innej tabeli to będziemy posiadać nadal wszystkie metody do niego przypisane.
Jedyny wyjątek w korzystaniu z VO jest przy ID Agregata, bo nie przypisujemy go stritke do wartości w 
tabeli, ale go zwracamy (w tabeli ustawiamy go jako string, ale funkcja get zwraca nam VO)

przykład VO: Board/Domain/Entity/BoardName
przykład zastosowania VO: Board/Domain/Entity/Board

przykład zastosowania VO jako ID: Board/Domain/Entity/Board linijka: 17, 25

Zalety:
 - Niezmienniczość: Wartości obiektów są zazwyczaj niemutowalne, co zapewnia spójność danych.
 - Prostota: Wartości obiektów mogą uprościć strukturę danych poprzez wyraźne określenie ich roli i funkcji.
 - Reużywalność: Wartości obiektów można łatwo wykorzystać w różnych częściach aplikacji.

Wady:
 - Dodatkowy poziom abstrakcji: Używanie wartości obiektów może zwiększyć poziom abstrakcji, co może być trudne do zrozumienia dla początkujących programistów.
 - Potencjalne problemy z identyfikacją: Wartości obiektów nie posiadają identyfikatorów, co może być problematyczne w przypadku konieczności odniesienia się do nich w kontekście bazy danych czy mapowania ORM.

### Warstwa Infrastruktury

#### Główne zasady:
1. W tej warstwie skupiamy sie na tworzeniu mapowania do doctrine
np. /User/Infrastructure/DoctrineMappings/User.orm.xml
Dokumentacja do mapowania w XML: https://www.doctrine-project.org/projects/doctrine-orm/en/3.1/reference/xml-mapping.html
2. Implementujemy repozytoria na podstawie interfejsów z warstwy **Domenowej**
przykład: port -> Board/Domain/RepositoryPort/BoardRepositoryInterface
adapter -> Board/Infrastructure/Repository/BoardRepository
3. Mamy dostęp tylko do warstwy **Domenowej**.


#### Mapowanie XML

Zalety:
 - Oddzielenie struktury bazy danych od kodu: Mapowanie przez XML pozwala na oddzielenie konfiguracji struktury bazy danych od kodu aplikacji, co ułatwia zarządzanie bazą danych.
 - Możliwość łatwej zmiany konfiguracji: Dzięki XML, konfiguracja struktury bazy danych może być łatwo zmieniana bez konieczności ingerencji w kod aplikacji.
 - Lepsza czytelność: Niektórzy programiści uważają, że mapowanie przez XML jest czytelniejsze od mapowania w PHP-owych adnotacjach.

Wady:
 - Dodatkowy krok w procesie rozwoju: Korzystanie z mapowania przez XML wymaga dodatkowego kroku w procesie rozwoju aplikacji, co może zwiększyć czas potrzebny na rozwój.
 - Możliwość popełnienia błędów: Ręczne tworzenie plików XML może prowadzić do popełnienia błędów, które mogą być trudne do zlokalizowania. (Można to zautomatyzować więć można naprawić tą wadę)
 - Mniejsza elastyczność: XML może być mniej elastyczny niż mapowanie za pomocą adnotacji PHP, szczególnie w przypadku bardziej skomplikowanych konfiguracji.

## Hexagonalna

Architektura Hexagonalna narzuca nam używanie Portów (Interfejsów) i Adapterów (Klas wykorzystujących Interfejsy).
W całym projekcie korzystamy tylko z Portów. Robimy to dlatego że mamy dokładnie ustalone dane wejściowe i wyjściowe z 
odpowiadających im metod. Na podstawie tych portów robimy Adaptery które zawsze możemy łatwo zaktualizować bez obaw
że coś sie po drodze nie będzie zgadzać. Między Domenami możemy korzystać z portów jak zajdzie taka potrzeba.

Przykład Portu: Board/Application/Port/BoardServiceInterface
Przykład Adaptera: Board/Application/Service/BoardService
Przykład wykorzystania Portu: Board/Application/Controller/GetBoardController

W architekturze Hexagonalnej też mamy podział na warstwy który działa podobnie do
podziału DDD którzy był już wyżej opisany.

## CQRS

Architektura CQRS każe nam dzielić rodzaje zapytań do bazy na dwie akcje:
- Query, czyli zapytania pobierające dane z bazy. (Nic nie ingerują w dane)
- Command, czyli zapytania edytujące dane w bazie. (Nic nie zwracają nam)

Zapytania te wysyłamy synchronicznie lub asynchronicznie przez messengera,
i w odpowiadających im handlerach wykonujemy przypisane im zadania.
W zapytaniach nie można załączać Obiektów doctrine.

Dzięki temu mamy dobrze oddzielone operacje na bazie danych i mamy odpowiednie miejsce 
gdzie wykonują się na niej operacje, przez co łatwiej będzie znaleźć błędy

przykład Query: Board/Application/Model/Query/FindBoardQuery
przykład handlera Query: Board/Application/Handler/FindBoardHandler
przykład użycia Query: Board/Application/Service/BoardService linijka: 38


# Przykład Drogi Dla Requesta Z API

## GET

1. Zaczynamy od odebrania requesta z endpointa: GetBoardController
2. Używając portu BoardServiceInterface wykonujemy funkcję findBoard i przekazujemy odebrane parametry z requesta
3. W Adapterze BoardService tworzymy Query (FindBoardQuery) aby pobrać wartość z bazy danych i wysyłamy je przez messengera.
4. W Handlerze FindBoardHandler wykonujemy odpowiednie operacje na bazie, czyli w tym przypadku pobieramy wartość z bazy danych
5. Wykonujemy odpowiednie sprawdzenia i w razie czego wyrzucamy Exception.
6. W Board Service odbieramy dane z Query, i przygotowujemy je pod odpowiedniego Responsa wykazanego z Portu
7. W GetBoardController dostajemy już przygotowany response, więc zamieniamy go na jsona i wysyłamy jako odpowiedź dla Usera.

## POST

1. Zaczynamy od odebrania requesta z endpointa: PostBoardController
2. Używając portu BoardServiceInterface wykonujemy funkcję createBoard i przekazujemy odebrane parametry z requesta
3. W Adapterze BoardService tworzymy Command (CreateBoardQuery) aby utworzyć nową wartość w bazie danych i wysyłamy je przez messengera.
4. W Handlerze CreateBoardHandler wykonujemy odpowiednie operacje na bazie, czyli w tym przypadku tworzymy nowy obiekt przez wbudowane funkcje w Agregacie
5. W Handlerze zapisujemy do bazy nowy obiekt
6. W Handlerze wysyłamy wszystkie eventy jakie sie zakolejkowały podczas tworzenia obiektu
7. W Handlerze nic nie zwracamy bo to był Command
8. W BoardService tworzymy defaultowego responsa kóry jest dla każdego commanda, i tworzymy informacje że wszystko przebiegło poprawnie
9. W PostBoardController odbieramy przygotowany response, zamieniamy go na jsona i wysyłamy jako odpowiedź dla Usera
