#include <iostream>
#include <sqlite3.h>
#include <string.h>
#include <fstream>

using namespace std;



int main(int argc, char** argv)
{

   //declare all the nessary things
   sqlite3 *db;
   sqlite3_stmt * stmt;
   const char *zSql;
   char begin[100];
   int columnNum = 0;
   int i = 0;


  //check the arguments
  if(argc != 4)
    {
      std::cout << "USAGE: " << argv[0] << " <database file> <table name> <CSV file>" << std::endl;
      return 1;
    }

   //using classic string munipulation instead of the c++ string api
   strcat(begin,"Select * from ");
   strcat(begin,argv[2]);
   strcat(begin,";");
   zSql = begin;

   //file operations
   ofstream csvFile(argv[3]);
   if(!csvFile.is_open()){
     std::cout<<"file couldn't open";
     return -1;
   }

    //open or create and check if the operation was succesful
   sqlite3_open(argv[1], &db);
   if(!db){
      std::cout<< "Can't open database: ";

   }else{
      std::cout<< "Opened database successfully\n";
   }



   //prepare the statment to select the data
   sqlite3_prepare(db,zSql,strlen(zSql),&stmt,NULL);

    while (1) {
            int s;

            s = sqlite3_step (stmt);
            if (s == SQLITE_ROW) {
                const unsigned char * text;
                columnNum = sqlite3_column_count(stmt);

                for(i=0;i<columnNum;i++){

                  //if it is text put it in quotes
                  if(sqlite3_column_type(stmt,i) == SQLITE_TEXT){
                    text  = sqlite3_column_text (stmt, i);
                    csvFile<<"'"<<text<<"'";
                    //if last add newline otherwise a comma
                    if(i == columnNum - 1){
                      csvFile<<endl;
                    }
                    else{
                      csvFile<<",";
                    }

                  }
                  else if(sqlite3_column_type(stmt,i) == SQLITE_INTEGER){
                    text = sqlite3_column_text(stmt,i);
                    csvFile<<text;
                    //if last add newline otherwise a comma
                    if(i == columnNum - 1){
                      csvFile<<endl;
                    }
                    else{
                      csvFile<<",";
                    }

                  }
                  else{
                    cout<<"not type int or varchar"<<endl;
                  }


                }

            }
            else if (s == SQLITE_DONE) {
                break;
            }
            else {
                std::cout<< "Failed.\n";
                return -1;
            }
        }



  //close everytnig up
   sqlite3_finalize(stmt);
   csvFile.close();
   sqlite3_close(db);

  return 0;
}
