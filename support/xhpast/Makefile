ifdef DEBUG
CPPFLAGS = -fPIC -ggdb -Wall -DDEBUG
else
CPPFLAGS = -fPIC -g -Wall -O3 -minline-all-stringops
endif

ifdef PROFILE
CPPFLAGS += -pg
endif

ROOT = ../../src/parser/xhpast

all: xhpast

clean:
	-rm xhpast parser.yacc.output libxhpast.a *.o 2>/dev/null

cleanall: clean
	-rm scanner.lex.cpp scanner.lex.hpp parser.yacc.cpp parser.yacc.hpp

install: xhpast
	cp xhpast $(ROOT)/bin/xhpast

scanner: scanner.l
	./find_flex.sh >/dev/null && \
		`./find_flex.sh` -C --header-file=scanner.lex.hpp -o scanner.lex.cpp -d $<
	echo '/* @generated */' >> scanner.lex.cpp
	echo '/* @generated */' >> scanner.lex.hpp

parser: parser.y
	bison --debug --verbose -d -o parser.yacc.cpp $<
	echo '/* @generated */' >> parser.yacc.cpp
	echo '/* @generated */' >> parser.yacc.hpp

node_names.hpp: generate_nodes.php
	php -f generate_nodes.php
	cp parser_nodes.php $(ROOT)/constants/

%.o: %.cpp
	$(CXX) -c $(CPPFLAGS) -o $@ $<

needparserscanner:
	 @([ -e parser.yacc.hpp ] && [ -e parser.yacc.cpp ] && \
	   [ -e scanner.lex.hpp ] && [ -e scanner.lex.cpp ]) \
		|| (echo "Run 'make parser scanner' first.'" && exit 1)

parser.yacc.o: needparserscanner scanner.lex.hpp

scanner.lex.o: needparserscanner parser.yacc.hpp node_names.hpp

libxhpast.a: astnode.o scanner.lex.o parser.yacc.o
	$(AR) -crs $@ $^

xhpast: xhpast.cpp libxhpast.a
	$(CXX) $(CPPFLAGS) -o $@ $^

.PHONY: all clean
